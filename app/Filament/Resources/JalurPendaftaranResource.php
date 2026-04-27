<?php

namespace App\Filament\Resources;

use App\Filament\Resources\JalurPendaftaranResource\Pages;
use App\Filament\Resources\JalurPendaftaranResource\RelationManagers;
use App\Models\JalurPendaftaran;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;

class JalurPendaftaranResource extends Resource
{
    protected static ?string $model = JalurPendaftaran::class;

    protected static ?string $navigationLabel = 'Data Jalur Pendaftaran';

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
                Forms\Components\Section::make('Data Jalur Pendaftaran')
                    ->schema([
                        Forms\Components\TextInput::make('nama_jalur')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\Select::make('periode_pendaftaran_id')
                            ->relationship('periode_pendaftaran', 'nama_periode')
                            ->required()
                            ->label('Periode Pendaftaran'),
                        Forms\Components\Textarea::make('deskripsi')
                            ->columnSpanFull(),
                    ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nama_jalur')->searchable(),
                Tables\Columns\TextColumn::make('periode_pendaftaran.nama_periode')->label('Periode'),
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
            'index' => Pages\ListJalurPendaftarans::route('/'),
            'create' => Pages\CreateJalurPendaftaran::route('/create'),
            'edit' => Pages\EditJalurPendaftaran::route('/{record}/edit'),
        ];
    }
}
