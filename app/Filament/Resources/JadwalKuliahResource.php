<?php

namespace App\Filament\Resources;

use App\Filament\Resources\JadwalKuliahResource\Pages;
use App\Filament\Resources\JadwalKuliahResource\RelationManagers;
use App\Models\JadwalKuliah;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;

class JadwalKuliahResource extends Resource
{
    protected static ?string $model = JadwalKuliah::class;

    protected static ?string $navigationLabel = 'Data Jadwal Kuliah';

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = 'Akademik';

    public static function canViewAny(): bool
    {
        return Auth::user()->can('akses_akademik');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Informasi Perkuliahan')
                    ->schema([
                        Forms\Components\Select::make('mata_kuliah_id')
                            ->label('Mata Kuliah')
                            ->relationship('mata_kuliah', 'nama_mata_kuliah')
                            ->required()
                            ->searchable()
                            ->preload(),
                        Forms\Components\Select::make('dosen_id')
                            ->label('Dosen Pengampu')
                            ->relationship(
                                name: 'dosen', 
                                titleAttribute: 'id', // Tetap 'id' agar tidak error ORDER BY dosens.name
                                modifyQueryUsing: fn ($query) => $query
                                    ->join('users', 'dosens.user_id', '=', 'users.id')
                                    ->select('dosens.*', 'users.name as user_name')
                            )
                            // 1. Tampilkan nama dosen saat record dipilih/sudah ada
                            ->getOptionLabelFromRecordUsing(fn ($record) => $record->user_name ?? $record->user?->name)
                            
                            // 2. Beritahu cara mencari (agar filter LIKE mengarah ke users.name)
                            ->searchable(['users.name']) 
                            
                            // 3. Tambahkan ini agar saat render ulang (setelah save/edit), namanya tetap muncul
                            ->getSearchResultsUsing(fn (string $search) => \App\Models\Dosen::role('Dosen')
                                ->join('users', 'dosens.user_id', '=', 'users.id')
                                ->where('users.name', 'ilike', "%{$search}%")
                                ->limit(50)
                                ->pluck('users.name', 'dosens.id')
                            )
                            ->getOptionLabelUsing(fn ($value): ?string => \App\Models\Dosen::find($value)?->user?->name)
                            
                            ->preload()
                            ->required(),

                        Forms\Components\Select::make('jenis_kelas_id')
                            ->label('Jenis Kelas')
                            ->relationship('jenis_kelas', 'nama_jenis_kelas')
                            ->required()
                            ->preload(),
                        // Catatan: Jika ada tabel master 'Kelas' khusus, ubah ini menjadi relationship. 
                        // Sementara kita pakai TextInput karena di master data tidak ada penjabaran CRUD Kelas khusus.
                        Forms\Components\TextInput::make('kelas')
                            ->label('Kelas (Contoh: TI-1A)')
                            ->required(),
                        Forms\Components\TextInput::make('beban_sks')
                            ->label('Beban SKS')
                            ->numeric()
                            ->required(),
                        Forms\Components\TextInput::make('pertemuan')
                            ->label('Pertemuan Ke-')
                            ->numeric()
                            ->required(),
                    ])->columns(2),

                Forms\Components\Section::make('Waktu & Tempat')
                    ->schema([
                        Forms\Components\Select::make('ruang_id')
                            ->label('Ruang')
                            ->relationship('ruang', 'nama_ruang')
                            ->required()
                            ->searchable()
                            ->preload(),
                        Forms\Components\Select::make('waktu_kuliah_id')
                            ->label('Waktu Kuliah')
                            ->relationship('waktu_kuliah', 'nama_waktu_kuliah')
                            ->required()
                            ->preload(),
                        Forms\Components\Select::make('hari')
                            ->label('Hari')
                            ->options([
                                'Senin' => 'Senin',
                                'Selasa' => 'Selasa',
                                'Rabu' => 'Rabu',
                                'Kamis' => 'Kamis',
                                'Jumat' => 'Jumat',
                                'Sabtu' => 'Sabtu',
                                'Minggu' => 'Minggu',
                            ])->required(),
                        Forms\Components\DatePicker::make('tanggal')
                            ->label('Tanggal')
                            ->required(),
                        Forms\Components\Select::make('metode')
                            ->label('Metode Perkuliahan')
                            ->options([
                                'Tatap Muka' => 'Tatap Muka',
                                'Online' => 'Online',
                            ])->required(),
                        Forms\Components\TextInput::make('link')
                            ->label('Link Kelas Online')
                            ->url()
                            ->hint('Opsional')
                            ->columnSpanFull(),
                    ])->columns(3),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('mata_kuliah.nama_mata_kuliah')
                ->label('Mata Kuliah')
                ->searchable(),
                Tables\Columns\TextColumn::make('dosen.user.name')
                    ->label('Dosen'),
                Tables\Columns\TextColumn::make('ruang.nama_ruang')
                    ->label('Ruang'),
                Tables\Columns\TextColumn::make('hari')
                    ->label('Hari'),
                Tables\Columns\TextColumn::make('waktu_kuliah.nama_waktu_kuliah')
                    ->label('Waktu'),
                Tables\Columns\TextColumn::make('metode')
                    ->label('Metode')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'Tatap Muka' => 'success',
                        'Online' => 'info',
                        default => 'gray',
                    }),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListJadwalKuliahs::route('/'),
            'create' => Pages\CreateJadwalKuliah::route('/create'),
            'edit' => Pages\EditJadwalKuliah::route('/{record}/edit'),
        ];
    }
}
