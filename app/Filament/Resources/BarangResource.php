<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BarangResource\Pages;
use App\Filament\Resources\BarangResource\RelationManagers;
use App\Models\Barang;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;

class BarangResource extends Resource
{
    protected static ?string $model = Barang::class;

    protected static ?string $navigationLabel = 'Data Barang';

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
                Forms\Components\Section::make('Informasi Barang')
                    ->schema([
                        Forms\Components\Select::make('kategori_barang_id')
                            ->relationship('kategori_barang', 'nama_kategori')
                            ->label('Kategori')
                            ->required()
                            ->searchable(),
                        Forms\Components\TextInput::make('nama_barang')
                            ->required(),
                        Forms\Components\TextInput::make('kode_barang')
                            ->required(),
                        Forms\Components\TextInput::make('merk'),
                        Forms\Components\TextInput::make('model'),
                        Forms\Components\TextInput::make('satuan')
                            ->placeholder('Contoh: Unit, Pcs, Set')
                            ->required(),
                        Forms\Components\FileUpload::make('foto_barang')
                            ->image()
                            ->directory('infrastruktur/barang'),
                        Forms\Components\Textarea::make('deskripsi')->columnSpanFull(),
                    ])->columns(3),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('foto_barang')->square(),
                Tables\Columns\TextColumn::make('nama_barang')->searchable(),
                Tables\Columns\TextColumn::make('kategori_barang.nama_kategori')->label('Kategori'),
                Tables\Columns\TextColumn::make('merk'),
                Tables\Columns\TextColumn::make('model'),
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
            'index' => Pages\ListBarangs::route('/'),
            'create' => Pages\CreateBarang::route('/create'),
            'edit' => Pages\EditBarang::route('/{record}/edit'),
        ];
    }
}
