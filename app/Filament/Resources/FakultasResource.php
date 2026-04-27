<?php

namespace App\Filament\Resources;

use App\Filament\Resources\FakultasResource\Pages;
use App\Filament\Resources\FakultasResource\RelationManagers;
use App\Models\Fakultas;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;

class FakultasResource extends Resource
{
    
    protected static ?string $navigationGroup = 'Akademik';

    protected static ?string $navigationLabel = 'Data Fakultas';
    protected static ?string $model = Fakultas::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    public static function canViewAny(): bool
    {
        return Auth::user()->can('akses_akademik');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Data Fakultas')
                    ->schema([
                        Forms\Components\TextInput::make('nama_fakultas')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('kode_fakultas')
                            ->required()
                            ->maxLength(50),
                        Forms\Components\Select::make('dekan_id')
                            ->label('Dekan')
                            ->relationship(
                                name: 'dekan', 
                                titleAttribute: 'name', // Filament tetap butuh ini sebagai referensi
                                modifyQueryUsing: fn ($query) => $query
                                    ->join('users', 'dosens.user_id', '=', 'users.id')
                                    ->select('dosens.*', 'users.name as name') // Alias yang jelas
                            )
                            ->searchable()
                            ->preload()
                        // Tambahkan ini untuk memastikan Filament mengurutkan ke kolom yang benar
                        ->getOptionLabelFromRecordUsing(fn ($record) => $record->name),

                        Forms\Components\Textarea::make('deskripsi')
                            ->columnSpanFull(),
                        Forms\Components\Select::make('status')
                            ->options([
                                'Aktif' => 'Aktif',
                                'Tidak Aktif' => 'Tidak Aktif',
                            ])->default('Aktif')->required(),
                    ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nama_fakultas')->searchable(),
                Tables\Columns\TextColumn::make('kode_fakultas'),
                Tables\Columns\TextColumn::make('dekan.user.name')->label('Dekan')->placeholder('Belum Ditentukan'),
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
            'index' => Pages\ListFakultas::route('/'),
            'create' => Pages\CreateFakultas::route('/create'),
            'edit' => Pages\EditFakultas::route('/{record}/edit'),
        ];
    }
}
