<?php

namespace App\Filament\Resources;

use App\Filament\Resources\GelombangResource\Pages;
use App\Filament\Resources\GelombangResource\RelationManagers;
use App\Models\Gelombang;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;

class GelombangResource extends Resource
{
    protected static ?string $model = Gelombang::class;

    protected static ?string $navigationLabel = 'Data Gelombang';

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
                Forms\Components\Section::make('Data Gelombang')
                    ->schema([
                        Forms\Components\TextInput::make('nama_gelombang')
                            ->required(),
                        Forms\Components\Select::make('periode_pendaftaran_id')
                            ->relationship('periode_pendaftaran', 'nama_periode')
                            ->label('Periode Pendaftaran')
                            ->required()
                            ->searchable()
                            ->preload(),
                        Forms\Components\Select::make('jalur_pendaftaran_id')
                            ->relationship('jalur_pendaftaran', 'nama_jalur')
                            ->required()
                            ->label('Jalur Pendaftaran'),
                        Forms\Components\DatePicker::make('tanggal_mulai')->required(),
                        Forms\Components\DatePicker::make('tanggal_selesai')->required(),
                        Forms\Components\Textarea::make('deskripsi')->columnSpanFull(),
                    ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nama_gelombang')->searchable(),
                Tables\Columns\TextColumn::make('jalur_pendaftaran.nama_jalur')->label('Jalur'),
                Tables\Columns\TextColumn::make('tanggal_mulai')->date(),
                Tables\Columns\TextColumn::make('tanggal_selesai')->date(),
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
            'index' => Pages\ListGelombangs::route('/'),
            'create' => Pages\CreateGelombang::route('/create'),
            'edit' => Pages\EditGelombang::route('/{record}/edit'),
        ];
    }
}
