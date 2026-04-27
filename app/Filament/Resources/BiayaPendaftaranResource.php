<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BiayaPendaftaranResource\Pages;
use App\Filament\Resources\BiayaPendaftaranResource\RelationManagers;
use App\Models\BiayaPendaftaran;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;

class BiayaPendaftaranResource extends Resource
{
    protected static ?string $model = BiayaPendaftaran::class;

    protected static ?string $navigationLabel = 'Biaya Pendaftaran';

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
                Forms\Components\Section::make('Biaya Pendaftaran')
                    ->schema([
                        Forms\Components\TextInput::make('nama_biaya')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\Select::make('jalur_pendaftaran_id')
                            ->relationship('jalur_pendaftaran', 'nama_jalur')
                            ->required()
                            ->label('Jalur Pendaftaran'),
                        Forms\Components\TextInput::make('nominal')
                            ->required()
                            ->numeric()
                            ->prefix('Rp'),
                        Forms\Components\Textarea::make('deskripsi')
                            ->columnSpanFull(),
                    ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nama_biaya')->searchable(),
                Tables\Columns\TextColumn::make('jalur_pendaftaran.nama_jalur')->label('Jalur'),
                Tables\Columns\TextColumn::make('nominal')->money('IDR'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make()
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
            'index' => Pages\ListBiayaPendaftarans::route('/'),
            'create' => Pages\CreateBiayaPendaftaran::route('/create'),
            'edit' => Pages\EditBiayaPendaftaran::route('/{record}/edit'),
        ];
    }
}
