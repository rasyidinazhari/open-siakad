<?php

namespace App\Filament\Resources;

use App\Filament\Resources\InventarisBarangResource\Pages;
use App\Filament\Resources\InventarisBarangResource\RelationManagers;
use App\Models\InventarisBarang;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;

class InventarisBarangResource extends Resource
{
    protected static ?string $model = InventarisBarang::class;

    protected static ?string $navigationLabel = 'Data Inventaris';

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
                Forms\Components\Section::make('Data Inventaris')
                    ->schema([
                        Forms\Components\Select::make('barang_id')
                            ->relationship('barang', 'nama_barang')
                            ->required()
                            ->searchable(),
                        Forms\Components\Select::make('ruang_id')
                            ->relationship('ruang', 'nama_ruang')
                            ->label('Lokasi')
                            ->required()
                            ->searchable(),
                        Forms\Components\TextInput::make('kode_inventaris')
                            ->required(),
                        Forms\Components\TextInput::make('jumlah')
                            ->numeric()
                            ->required(),
                        Forms\Components\Select::make('kondisi')
                            ->options([
                                'Baik' => 'Baik',
                                'Rusak Ringan' => 'Rusak Ringan',
                                'Rusak Berat' => 'Rusak Berat',
                            ])->required(),
                        Forms\Components\Select::make('status')
                            ->options([
                                'Aktif' => 'Aktif',
                                'Tidak Aktif' => 'Tidak Aktif',
                            ])->required(),
                        Forms\Components\FileUpload::make('foto')
                            ->image()
                            ->directory('infrastruktur/inventaris'),
                        Forms\Components\Textarea::make('deskripsi')->columnSpanFull(),
                    ])->columns(3),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('barang.nama_barang')->label('Barang')->searchable(),
                Tables\Columns\TextColumn::make('ruang.nama_ruang')->label('Lokasi'),
                Tables\Columns\TextColumn::make('kode_inventaris'),
                Tables\Columns\TextColumn::make('jumlah')->numeric(),
                Tables\Columns\TextColumn::make('kondisi')->badge(),
                Tables\Columns\TextColumn::make('status')->badge(),
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
            'index' => Pages\ListInventarisBarangs::route('/'),
            'create' => Pages\CreateInventarisBarang::route('/create'),
            'edit' => Pages\EditInventarisBarang::route('/{record}/edit'),
        ];
    }
}
