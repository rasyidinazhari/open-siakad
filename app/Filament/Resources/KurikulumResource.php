<?php

namespace App\Filament\Resources;

use App\Filament\Resources\KurikulumResource\Pages;
use App\Filament\Resources\KurikulumResource\RelationManagers;
use App\Models\Kurikulum;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;

class KurikulumResource extends Resource
{
    protected static ?string $model = Kurikulum::class;

    protected static ?string $navigationLabel = 'Data Kurikulum';

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = 'Akademik';

    public static function canViewAny(): bool
    {
        return Auth::user()->can('akses_akademik');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Data Kurikulum')
                    ->schema([
                        Forms\Components\Select::make('program_studi_id')
                            ->relationship('program_studi', 'nama_program_studi')
                            ->required()
                            ->searchable()
                            ->preload(),
                        Forms\Components\TextInput::make('nama_kurikulum')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('kode_kurikulum')
                            ->required()
                            ->maxLength(50),
                        Forms\Components\TextInput::make('tahun_mulai')
                            ->label('Tahun Mulai Berlaku')
                            ->numeric()
                            ->required(),
                        Forms\Components\TextInput::make('tahun_berakhir')
                            ->label('Tahun Berakhir')
                            ->numeric()
                            ->hint('Opsional'),
                        Forms\Components\Select::make('status')
                            ->options([
                                'Masih Berlaku' => 'Masih Berlaku',
                                'Tidak Berlaku' => 'Tidak Berlaku',
                            ])->default('Masih Berlaku')->required(),
                        Forms\Components\Textarea::make('deskripsi')
                            ->columnSpanFull(),
                    ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nama_kurikulum')->searchable(),
                Tables\Columns\TextColumn::make('kode_kurikulum')->searchable(),
                Tables\Columns\TextColumn::make('program_studi.nama_program_studi')->label('Program Studi'),
                Tables\Columns\TextColumn::make('tahun_mulai'),
                Tables\Columns\TextColumn::make('tahun_berakhir')->placeholder('Seterusnya'),
                Tables\Columns\TextColumn::make('status')->badge(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
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
            'index' => Pages\ListKurikulums::route('/'),
            'create' => Pages\CreateKurikulum::route('/create'),
            'edit' => Pages\EditKurikulum::route('/{record}/edit'),
        ];
    }
}
