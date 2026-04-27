<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TagihanKuliahResource\Pages;
use App\Filament\Resources\TagihanKuliahResource\RelationManagers;
use App\Models\TagihanKuliah;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;

class TagihanKuliahResource extends Resource
{
    protected static ?string $model = TagihanKuliah::class;

    protected static ?string $navigationLabel = 'Data Tagihan Kuliah';

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = 'Keuangan';

    public static function canViewAny(): bool
    {
        return Auth::user()->can('akses_keuangan') || Auth::user()->hasRole('Web Administrator');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Detail Tagihan')
                    ->schema([
                        Forms\Components\Select::make('mahasiswa_id')
                            ->relationship('mahasiswa', 'nim') // Idealnya digabung dengan nama
                            ->label('Mahasiswa')
                            ->required()
                            ->searchable(),
                        Forms\Components\Select::make('tahun_akademik_id')
                            ->relationship('tahun_akademik', 'nama_tahun')
                            ->required(),
                        Forms\Components\TextInput::make('nama_tagihan')
                            ->placeholder('Contoh: SPP Semester Ganjil 2024')
                            ->required(),
                        Forms\Components\TextInput::make('nominal')
                            ->numeric()
                            ->prefix('Rp')
                            ->required(),
                        Forms\Components\DatePicker::make('tenggat_waktu')
                            ->label('Jatuh Tempo')
                            ->required(),
                        Forms\Components\Select::make('status')
                            ->options([
                                'Belum Lunas' => 'Belum Lunas',
                                'Lunas' => 'Lunas',
                            ])->default('Belum Lunas')->required(),
                    ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('mahasiswa.user.name')->label('Mahasiswa')->searchable(),
                Tables\Columns\TextColumn::make('nama_tagihan')->label('Jenis Tagihan'),
                Tables\Columns\TextColumn::make('nominal')->money('IDR'),
                Tables\Columns\TextColumn::make('tenggat_waktu')->date()->label('Jatuh Tempo'),
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
            'index' => Pages\ListTagihanKuliahs::route('/'),
            'create' => Pages\CreateTagihanKuliah::route('/create'),
            'edit' => Pages\EditTagihanKuliah::route('/{record}/edit'),
        ];
    }
}
