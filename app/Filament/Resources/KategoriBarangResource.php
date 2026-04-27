<?php

namespace App\Filament\Resources;

use App\Filament\Resources\KategoriBarangResource\Pages;
use App\Filament\Resources\KategoriBarangResource\RelationManagers;
use App\Models\KategoriBarang;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class KategoriBarangResource extends Resource
{
    protected static ?string $model = KategoriBarang::class;

    protected static ?string $navigationLabel = 'Data Kategori Barang';

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
                Forms\Components\Section::make('Kategori Barang')
                    ->schema([
                        Forms\Components\TextInput::make('nama_kategori')
                            ->required()
                            ->live(onBlur: true)
                            ->afterStateUpdated(fn (Forms\Set $set, ?string $state) => $set('slug', Str::slug($state))),
                        Forms\Components\TextInput::make('kode')
                            ->required(),
                        Forms\Components\TextInput::make('slug')
                            ->required()
                            ->unique(ignoreRecord: true),   
                        Forms\Components\Textarea::make('deskripsi')
                            ->columnSpanFull(),
                    ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nama_kategori')->searchable(),
                Tables\Columns\TextColumn::make('kode'),
                Tables\Columns\TextColumn::make('slug'),
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
            'index' => Pages\ListKategoriBarangs::route('/'),
            'create' => Pages\CreateKategoriBarang::route('/create'),
            'edit' => Pages\EditKategoriBarang::route('/{record}/edit'),
        ];
    }
}
