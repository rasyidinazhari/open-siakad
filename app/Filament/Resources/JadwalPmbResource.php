<?php

namespace App\Filament\Resources;

use App\Filament\Resources\JadwalPmbResource\Pages;
use App\Filament\Resources\JadwalPmbResource\RelationManagers;
use App\Models\JadwalPmb;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;

class JadwalPmbResource extends Resource
{
    protected static ?string $model = JadwalPmb::class;

    protected static ?string $navigationLabel = 'Data Jadwal PMB';

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = 'PMB / Admisi';

    public static function canViewAny(): bool
    {
        return Auth::user()->can('akses_admisi') || Auth::user()->hasRole('Web Administrator');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Jadwal Kegiatan PMB')
                    ->schema([
                        Forms\Components\TextInput::make('nama_jadwal')
                            ->required(),
                        Forms\Components\Select::make('tipe_jadwal')
                            ->options([
                                'Pendaftaran' => 'Pendaftaran',
                                'Tes' => 'Tes',
                                'Wawancara' => 'Wawancara',
                                'Pengumuman' => 'Pengumuman',
                                'Daftar Ulang' => 'Daftar Ulang',
                            ])->required(),
                        Forms\Components\Select::make('gelombang_id')
                            ->relationship('gelombang', 'nama_gelombang')
                            ->required(),
                        Forms\Components\DatePicker::make('tanggal_mulai')->required(),
                        Forms\Components\DatePicker::make('tanggal_selesai')->required(),
                        Forms\Components\Textarea::make('deskripsi')->columnSpanFull(),
                    ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nama_jadwal')->searchable(),
                Tables\Columns\TextColumn::make('tipe_jadwal')->badge(),
                Tables\Columns\TextColumn::make('gelombang.nama_gelombang')->label('Gelombang'),
                Tables\Columns\TextColumn::make('tanggal_mulai')->date(),
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
            'index' => Pages\ListJadwalPmbs::route('/'),
            'create' => Pages\CreateJadwalPmb::route('/create'),
            'edit' => Pages\EditJadwalPmb::route('/{record}/edit'),
        ];
    }
}
