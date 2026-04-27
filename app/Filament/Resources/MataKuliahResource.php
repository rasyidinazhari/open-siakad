<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MataKuliahResource\Pages;
use App\Filament\Resources\MataKuliahResource\RelationManagers;
use App\Models\MataKuliah;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;

class MataKuliahResource extends Resource
{
    protected static ?string $model = MataKuliah::class;

    protected static ?string $navigationLabel = 'Data Mata Kuliah';

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
                Forms\Components\Section::make('Informasi Dasar Mata Kuliah')
                    ->schema([
                        Forms\Components\Select::make('kurikulum_id')
                            ->relationship('kurikulum', 'nama_kurikulum')
                            ->required()
                            ->preload(),
                        Forms\Components\Select::make('program_studi_id')
                            ->relationship('program_studi', 'nama_program_studi')
                            ->required()
                            ->preload(),
                        Forms\Components\TextInput::make('kode_mata_kuliah')
                            ->required(),
                        Forms\Components\TextInput::make('nama_mata_kuliah')
                            ->required(),
                        Forms\Components\TextInput::make('semester')
                            ->numeric()
                            ->required(),
                        Forms\Components\TextInput::make('sks')
                            ->label('SKS')
                            ->numeric()
                            ->required(),
                        // Prasyarat mengambil data dari tabel mata_kuliah itu sendiri
                        Forms\Components\Select::make('prasyarat_id')
                            ->label('Mata Kuliah Prasyarat')
                            ->relationship('prasyarat', 'nama_mata_kuliah')
                            ->searchable()
                            ->preload()
                            ->hint('Opsional'),
                    ])->columns(2),

                Forms\Components\Section::make('Dosen Pengampu')
                    ->description('Pilih dosen yang mengampu mata kuliah ini.')
                    ->schema([
                        Forms\Components\Select::make('dosen_1_id')
                            ->label('Dosen 1 (Utama)')
                            ->relationship(
                                name: 'dosen_1', 
                                titleAttribute: 'id', // Tetap id supaya tidak error order by di awal
                                modifyQueryUsing: fn ($query) => $query
                                    ->join('users', 'dosens.user_id', '=', 'users.id')
                                    ->select('dosens.*', 'users.name as nama_dosen') // Kasih alias 'nama_dosen'
                            )
                            // Tampilkan alias 'nama_dosen' tadi di dropdown
                            ->getOptionLabelFromRecordUsing(fn ($record) => $record->nama_dosen) 
                            // Biarkan user tetap bisa cari berdasarkan nama
                            ->searchable(['users.name']) 
                            ->preload()
                            ->required(),

                        Forms\Components\Select::make('dosen_2_id')
                            ->label('Dosen 2 ')
                            ->relationship(
                                name: 'dosen_2', 
                                titleAttribute: 'id', // Tetap id supaya tidak error order by di awal
                                modifyQueryUsing: fn ($query) => $query
                                    ->join('users', 'dosens.user_id', '=', 'users.id')
                                    ->select('dosens.*', 'users.name as nama_dosen') // Kasih alias 'nama_dosen'
                            )
                            // Tampilkan alias 'nama_dosen' tadi di dropdown
                            ->getOptionLabelFromRecordUsing(fn ($record) => $record->nama_dosen) 
                            // Biarkan user tetap bisa cari berdasarkan nama
                            ->searchable(['users.name']) 
                            ->preload(),
                            

                        Forms\Components\Select::make('dosen_3_id')
                            ->label('Dosen 3 ')
                            ->relationship(
                                name: 'dosen_3', 
                                titleAttribute: 'id', // Tetap id supaya tidak error order by di awal
                                modifyQueryUsing: fn ($query) => $query
                                    ->join('users', 'dosens.user_id', '=', 'users.id')
                                    ->select('dosens.*', 'users.name as nama_dosen') // Kasih alias 'nama_dosen'
                            )
                            // Tampilkan alias 'nama_dosen' tadi di dropdown
                            ->getOptionLabelFromRecordUsing(fn ($record) => $record->nama_dosen) 
                            // Biarkan user tetap bisa cari berdasarkan nama
                            ->searchable(['users.name']) 
                            ->preload(),
                    ])->columns(3),


                Forms\Components\Section::make('Dokumen & Deskripsi')
                    ->schema([
                        Forms\Components\FileUpload::make('dokumen_rps')
                            ->label('Dokumen RPS (Opsional)')
                            ->acceptedFileTypes(['application/pdf']),
                        Forms\Components\FileUpload::make('dokumen_kontrak_kuliah')
                            ->label('Dokumen Kontrak Kuliah (Opsional)')
                            ->acceptedFileTypes(['application/pdf']),
                        Forms\Components\Textarea::make('deskripsi_mata_kuliah')
                            ->columnSpanFull(),
                    ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('kode_mata_kuliah')->searchable(),
                Tables\Columns\TextColumn::make('nama_mata_kuliah')->searchable(),
                Tables\Columns\TextColumn::make('program_studi.nama_program_studi')->label('Prodi'),
                Tables\Columns\TextColumn::make('semester'),
                Tables\Columns\TextColumn::make('sks')->label('SKS'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
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
            'index' => Pages\ListMataKuliahs::route('/'),
            'create' => Pages\CreateMataKuliah::route('/create'),
            'edit' => Pages\EditMataKuliah::route('/{record}/edit'),
        ];
    }
}
