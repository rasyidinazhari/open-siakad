<?php

namespace App\Filament\Resources;

use App\Filament\Resources\GedungResource\Pages;
use App\Filament\Resources\GedungResource\RelationManagers;
use App\Models\Gedung;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;

class GedungResource extends Resource
{
    protected static ?string $model = Gedung::class;

    protected static ?string $navigationLabel = 'Data Gedung';

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = 'Infrastruktur'; // [cite: 71]

    public static function canViewAny(): bool
    {
        return Auth::user()->can('akses_infrastruktur'); // [cite: 106, 108]
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Informasi Gedung')
                    ->schema([
                        Forms\Components\TextInput::make('nama_gedung')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('kode_gedung')
                            ->required()
                            ->maxLength(50),
                        Forms\Components\FileUpload::make('foto_gedung')
                            ->image()
                            ->directory('infrastruktur/gedung'),
                        Forms\Components\Textarea::make('deskripsi')
                            ->columnSpanFull(),
                    ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('foto_gedung')->square(),
                Tables\Columns\TextColumn::make('nama_gedung')->searchable(),
                Tables\Columns\TextColumn::make('kode_gedung'),
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
            'index' => Pages\ListGedungs::route('/'),
            'create' => Pages\CreateGedung::route('/create'),
            'edit' => Pages\EditGedung::route('/{record}/edit'),
        ];
    }
}
