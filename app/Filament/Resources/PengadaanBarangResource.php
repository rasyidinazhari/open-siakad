<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PengadaanBarangResource\Pages;
use App\Filament\Resources\PengadaanBarangResource\RelationManagers;
use App\Models\PengadaanBarang;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;

class PengadaanBarangResource extends Resource
{
    protected static ?string $model = PengadaanBarang::class;

    protected static ?string $navigationLabel = 'Data Pengadaan Barang';

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
                Forms\Components\Section::make('Data Pengadaan')
                    ->schema([
                        Forms\Components\Select::make('barang_id')
                            ->relationship('barang', 'nama_barang')
                            ->required()
                            ->searchable(),
                        Forms\Components\TextInput::make('jumlah')
                            ->numeric()
                            ->required(),
                        Forms\Components\TextInput::make('harga_satuan')
                            ->numeric()
                            ->prefix('Rp')
                            ->required(),
                        Forms\Components\TextInput::make('sumber_dana')
                            ->required(),
                        Forms\Components\DatePicker::make('tanggal_pengadaan')
                            ->required(),
                        Forms\Components\DatePicker::make('tanggal_pembelian'),
                        Forms\Components\Select::make('status')
                            ->options([
                                'Pending' => 'Pending',
                                'Disetujui' => 'Disetujui',
                                'Ditolak' => 'Ditolak',
                            ])->default('Pending')->required(),
                        Forms\Components\Textarea::make('deskripsi')->columnSpanFull(),
                    ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('barang.nama_barang')->label('Barang')->searchable(),
                Tables\Columns\TextColumn::make('tanggal_pengadaan')->date(),
                Tables\Columns\TextColumn::make('jumlah')->numeric(),
                Tables\Columns\TextColumn::make('harga_satuan')->money('IDR'),
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
            'index' => Pages\ListPengadaanBarangs::route('/'),
            'create' => Pages\CreatePengadaanBarang::route('/create'),
            'edit' => Pages\EditPengadaanBarang::route('/{record}/edit'),
        ];
    }
}
