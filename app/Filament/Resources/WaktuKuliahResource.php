<?php

namespace App\Filament\Resources;

use App\Filament\Resources\WaktuKuliahResource\Pages;
use App\Filament\Resources\WaktuKuliahResource\RelationManagers;
use App\Models\WaktuKuliah;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;

class WaktuKuliahResource extends Resource
{
    protected static ?string $model = WaktuKuliah::class;

    protected static ?string $navigationLabel = 'Data Waktu Kuliah';

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
                Forms\Components\Section::make('Data Waktu Kuliah')
                    ->schema([
                        Forms\Components\TextInput::make('nama_waktu_kuliah')
                            ->label('Nama Waktu Kuliah')
                            ->placeholder('Contoh: Sesi 1 Pagi')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\Select::make('jenis_kelas_id')
                            ->label('Jenis Kelas')
                            ->relationship('jenis_kelas', 'nama_jenis_kelas')
                            ->required()
                            ->searchable()
                            ->preload(),
                        Forms\Components\TimePicker::make('waktu_mulai')
                            ->label('Waktu Mulai')
                            ->required(),
                        Forms\Components\TimePicker::make('waktu_selesai')
                            ->label('Waktu Selesai')
                            ->required(),
                    ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nama_waktu_kuliah')
                    ->label('Nama Waktu Kuliah')
                    ->searchable(),
                Tables\Columns\TextColumn::make('jenis_kelas.nama_jenis_kelas')
                    ->label('Jenis Kelas')
                    ->searchable(),
                Tables\Columns\TextColumn::make('waktu_mulai')
                    ->label('Mulai')
                    ->time('H:i'),
                Tables\Columns\TextColumn::make('waktu_selesai')
                    ->label('Selesai')
                    ->time('H:i'),
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
            'index' => Pages\ListWaktuKuliahs::route('/'),
            'create' => Pages\CreateWaktuKuliah::route('/create'),
            'edit' => Pages\EditWaktuKuliah::route('/{record}/edit'),
        ];
    }
}
