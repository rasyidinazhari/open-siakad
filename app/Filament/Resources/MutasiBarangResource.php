<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MutasiBarangResource\Pages;
use App\Filament\Resources\MutasiBarangResource\RelationManagers;
use App\Models\MutasiBarang;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;

class MutasiBarangResource extends Resource
{
    protected static ?string $model = MutasiBarang::class;

    protected static ?string $navigationLabel = 'Data Mutasi Barang';

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
                Forms\Components\Section::make('Pencatatan Mutasi')
                    ->schema([
                        Forms\Components\Select::make('barang_id')
                            ->relationship('barang', 'nama_barang')
                            ->required()
                            ->searchable(),
                        Forms\Components\TextInput::make('jumlah')
                            ->numeric()
                            ->required(),
                        Forms\Components\Select::make('lokasi_awal_id')
                            ->relationship('lokasi_awal', 'nama_ruang')
                            ->label('Lokasi Awal')
                            ->required()
                            ->searchable(),
                        Forms\Components\Select::make('lokasi_akhir_id')
                            ->relationship('lokasi_akhir', 'nama_ruang')
                            ->label('Lokasi Akhir')
                            ->required()
                            ->searchable(),
                        Forms\Components\Select::make('kondisi')
                            ->options([
                                'Baik' => 'Baik',
                                'Rusak Ringan' => 'Rusak Ringan',
                                'Rusak Berat' => 'Rusak Berat',
                            ])->required(),
                        Forms\Components\FileUpload::make('foto')
                            ->image()
                            ->directory('infrastruktur/mutasi'),
                        Forms\Components\Textarea::make('deskripsi')->columnSpanFull(),
                    ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('barang.nama_barang')->label('Barang')->searchable(),
                Tables\Columns\TextColumn::make('lokasi_awal.nama_ruang')
                    ->label('Lokasi Asal')
                    ->searchable(),

                Tables\Columns\TextColumn::make('lokasi_akhir.nama_ruang')
                    ->label('Lokasi Tujuan')
                    ->searchable(),

                Tables\Columns\TextColumn::make('jumlah')->numeric(),
                Tables\Columns\TextColumn::make('kondisi')->badge(),
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
            'index' => Pages\ListMutasiBarangs::route('/'),
            'create' => Pages\CreateMutasiBarang::route('/create'),
            'edit' => Pages\EditMutasiBarang::route('/{record}/edit'),
        ];
    }
}
