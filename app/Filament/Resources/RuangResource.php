<?php

namespace App\Filament\Resources;

use App\Filament\Resources\RuangResource\Pages;
use App\Filament\Resources\RuangResource\RelationManagers;
use App\Models\Ruang;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;

class RuangResource extends Resource
{
    protected static ?string $model = Ruang::class;

    protected static ?string $navigationLabel = 'Data Ruangan';

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
                Forms\Components\Section::make('Detail Ruangan')
                    ->schema([
                        Forms\Components\Select::make('gedung_id')
                            ->relationship('gedung', 'nama_gedung')
                            ->required()
                            ->searchable()
                            ->preload(),
                        Forms\Components\TextInput::make('nama_ruang')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('lantai')
                            ->required()
                            ->maxLength(50),
                        Forms\Components\TextInput::make('kapasitas')
                            ->numeric()
                            ->required(),
                        Forms\Components\Select::make('tipe_ruang')
                            ->options([
                                'Ruang Publik' => 'Ruang Publik',
                                'Kelas' => 'Kelas',
                                'Pelayanan' => 'Pelayanan',
                                'Khusus' => 'Khusus',
                                'Gudang' => 'Gudang',
                            ])->required(),
                        Forms\Components\FileUpload::make('foto_ruang')
                            ->image()
                            ->directory('infrastruktur/ruang'),
                        Forms\Components\Textarea::make('deskripsi')
                            ->columnSpanFull(),
                    ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nama_ruang')->searchable(),
                Tables\Columns\TextColumn::make('gedung.nama_gedung')->label('Gedung'),
                Tables\Columns\TextColumn::make('lantai'),
                Tables\Columns\TextColumn::make('tipe_ruang')->badge(),
                Tables\Columns\TextColumn::make('kapasitas')->numeric(),
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
            'index' => Pages\ListRuangs::route('/'),
            'create' => Pages\CreateRuang::route('/create'),
            'edit' => Pages\EditRuang::route('/{record}/edit'),
        ];
    }
}
