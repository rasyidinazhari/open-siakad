<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TahunAkademikResource\Pages;
use App\Filament\Resources\TahunAkademikResource\RelationManagers;
use App\Models\TahunAkademik;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;

class TahunAkademikResource extends Resource
{
    
    protected static ?string $navigationGroup = 'Akademik';

    protected static ?string $navigationLabel = 'Data Tahun Akademik';

    protected static ?string $model = TahunAkademik::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function canViewAny(): bool
    {
        return Auth::user()->can('akses_akademik');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Form Tahun Akademik')
                    ->schema([
                        Forms\Components\TextInput::make('nama')
                            ->label('Nama Tahun Akademik')
                            ->placeholder('Contoh: 2023/2024')
                            ->required(),
                        Forms\Components\Select::make('semester')
                            ->label('Tipe Semester')
                            ->options([
                                'Ganjil' => 'Ganjil',
                                'Genap' => 'Genap',
                            ])
                            ->required(),
                        Forms\Components\DatePicker::make('tanggal_mulai')
                            ->required(),
                        Forms\Components\DatePicker::make('tanggal_berakhir')
                            ->required(),
                        Forms\Components\Textarea::make('deskripsi')
                            ->columnSpanFull(),
                        Forms\Components\Toggle::make('is_active')
                            ->label('Status Aktif')
                            ->default(true)
                            ->required(),
                    ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nama')->label('Tahun Akademik')->searchable(),
                Tables\Columns\TextColumn::make('semester')->label('Semester'),
                Tables\Columns\TextColumn::make('tanggal_mulai')->label('Mulai')->date(),
                Tables\Columns\TextColumn::make('tanggal_berakhir')->label('Berakhir')->date(),
                Tables\Columns\IconColumn::make('is_active')
                    ->label('Status Aktif')
                    ->boolean()
                    ->trueIcon('heroicon-o-check-circle')
                    ->falseIcon('heroicon-o-x-circle'),
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
            'index' => Pages\ListTahunAkademiks::route('/'),
            'create' => Pages\CreateTahunAkademik::route('/create'),
            'edit' => Pages\EditTahunAkademik::route('/{record}/edit'),
        ];
    }
}
