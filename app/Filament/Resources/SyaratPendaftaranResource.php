<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SyaratPendaftaranResource\Pages;
use App\Filament\Resources\SyaratPendaftaranResource\RelationManagers;
use App\Models\SyaratPendaftaran;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;

class SyaratPendaftaranResource extends Resource
{
    protected static ?string $model = SyaratPendaftaran::class;

    protected static ?string $navigationLabel = 'Data Syarat Pendaftaran';

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
                Forms\Components\Section::make('Syarat Berkas')
                    ->schema([
                        Forms\Components\TextInput::make('nama_syarat')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\Select::make('jalur_pendaftaran_id')
                            ->relationship('jalur_pendaftaran', 'nama_jalur')
                            ->required()
                            ->label('Jalur Pendaftaran'),
                        Forms\Components\Textarea::make('deskripsi')
                            ->columnSpanFull(),
                    ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nama_syarat')->searchable(),
                Tables\Columns\TextColumn::make('jalur_pendaftaran.nama_jalur')->label('Jalur'),
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
            'index' => Pages\ListSyaratPendaftarans::route('/'),
            'create' => Pages\CreateSyaratPendaftaran::route('/create'),
            'edit' => Pages\EditSyaratPendaftaran::route('/{record}/edit'),
        ];
    }
}
