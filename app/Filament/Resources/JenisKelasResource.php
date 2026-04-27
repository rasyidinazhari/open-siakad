<?php

namespace App\Filament\Resources;

use App\Filament\Resources\JenisKelasResource\Pages;
use App\Filament\Resources\JenisKelasResource\RelationManagers;
use App\Models\JenisKelas;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;

class JenisKelasResource extends Resource
{
    protected static ?string $model = JenisKelas::class;

    protected static ?string $navigationLabel = 'Data Jenis Kelas';

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
                Forms\Components\Section::make('Detail Jenis Kelas')
                    ->schema([
                        Forms\Components\TextInput::make('kode_jenis_kelas')
                            ->required()
                            ->maxLength(50),
                        Forms\Components\TextInput::make('nama_jenis_kelas')
                            ->placeholder('Contoh: Reguler, Karyawan')
                            ->required()
                            ->maxLength(255),
                        
                        // PERBAIKAN DISINI: Gunakan Toggle untuk tipe data boolean
                        Forms\Components\Toggle::make('status')
                            ->label('Status Aktif')
                            ->default(true)
                            ->required(),

                        Forms\Components\Textarea::make('deskripsi')
                            ->columnSpanFull(),
                    ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nama_jenis_kelas')
                    ->searchable()
                    ->weight('bold')
                    ->description(fn (JenisKelas $record): string => $record->deskripsi ?? ''),
                Tables\Columns\TextColumn::make('kode_jenis_kelas'),
                
                // PERBAIKAN DISINI: Gunakan IconColumn untuk tipe data boolean
                Tables\Columns\IconColumn::make('status')
                    ->label('Status Aktif')
                    ->boolean()
                    ->trueIcon('heroicon-o-check-circle')
                    ->falseIcon('heroicon-o-x-circle'),
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
            'index' => Pages\ListJenisKelas::route('/'),
            'create' => Pages\CreateJenisKelas::route('/create'),
            'edit' => Pages\EditJenisKelas::route('/{record}/edit'),
        ];
    }
}
