<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PeriodePendaftaranResource\Pages;
use App\Filament\Resources\PeriodePendaftaranResource\RelationManagers;
use App\Models\PeriodePendaftaran;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;

class PeriodePendaftaranResource extends Resource
{
    protected static ?string $model = PeriodePendaftaran::class;

    protected static ?string $navigationLabel = 'Data Periode Pendaftaran';

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
                Forms\Components\Section::make('Data Periode PMB')
                    ->schema([
                        Forms\Components\Select::make('tahun_akademik_id')
                            ->relationship('tahun_akademik', 'nama')
                            ->required()
                            ->label('Tahun Akademik'),
                        Forms\Components\TextInput::make('nama_periode')
                            ->required()
                            ->placeholder('Contoh: PMB 2024/2025')
                            ->maxLength(255),
                        Forms\Components\DatePicker::make('tanggal_mulai')
                            ->required(),
                        Forms\Components\DatePicker::make('tanggal_selesai')
                            ->required(),
                        Forms\Components\Textarea::make('deskripsi')
                            ->columnSpanFull(),
                    ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nama_periode')->searchable(),
                Tables\Columns\TextColumn::make('tahun_akademik.nama')->label('Tahun Akademik'),
                Tables\Columns\TextColumn::make('tanggal_mulai')->date()->label('Mulai'),
                Tables\Columns\TextColumn::make('tanggal_selesai')->date()->label('Selesai'),
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
            'index' => Pages\ListPeriodePendaftarans::route('/'),
            'create' => Pages\CreatePeriodePendaftaran::route('/create'),
            'edit' => Pages\EditPeriodePendaftaran::route('/{record}/edit'),
        ];
    }
}
