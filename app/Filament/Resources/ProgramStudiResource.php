<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProgramStudiResource\Pages;
use App\Filament\Resources\ProgramStudiResource\RelationManagers;
use App\Models\ProgramStudi;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;

class ProgramStudiResource extends Resource
{
    
    protected static ?string $navigationGroup = 'Akademik';

    protected static ?string $navigationLabel = 'Data Program Studi';
    protected static ?string $model = ProgramStudi::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function canViewAny(): bool
    {
        return Auth::user()->can('akses_akademik');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Informasi Dasar')
                    ->schema([
                        Forms\Components\Select::make('fakultas_id')
                            ->relationship('fakultas', 'nama_fakultas')
                            ->required()
                            ->preload(),
                        Forms\Components\Select::make('kaprodi_id') // atau dosen_id
                            ->label('Kepala Program Studi')
                            ->relationship(
                                name: 'kaprodi', 
                                titleAttribute: 'name', 
                                modifyQueryUsing: fn ($query) => $query
                                    ->join('users', 'dosens.user_id', '=', 'users.id')
                                    ->select('dosens.*', 'users.name as name')
                            )
                            // WAJIB: Beritahu Filament bahwa pencarian 'name' harus ke 'users.name'
                            ->searchable(['users.name']) 
                            ->preload()
                            ->getOptionLabelFromRecordUsing(fn ($record) => $record->name),
                        Forms\Components\TextInput::make('nama_program_studi')->required(),
                        Forms\Components\TextInput::make('kode_prodi')->required(),
                    ])->columns(2),

                Forms\Components\Section::make('Detail Akademik')
                    ->schema([
                        Forms\Components\Select::make('jenjang')
                            ->options([
                                'Diploma' => 'Diploma',
                                'Sarjana' => 'Sarjana',
                                'Magister' => 'Magister',
                                'Doktoral' => 'Doktoral',
                            ])->required(),
                        Forms\Components\Select::make('gelar')
                            ->options([
                                'D3' => 'D3',
                                'S1' => 'S1',
                                'S2' => 'S2',
                                'S3' => 'S3',
                            ])->required(),
                        Forms\Components\TextInput::make('gelar_akhir')->required(),
                        Forms\Components\TextInput::make('akreditasi'),
                        Forms\Components\TextInput::make('durasi')->label('Durasi (Tahun)')->numeric(),
                        Forms\Components\Select::make('status')
                            ->options([
                                'Aktif' => 'Aktif',
                                'Tidak Aktif' => 'Tidak Aktif',
                            ])->default('Aktif')->required(),
                    ])->columns(3),

                Forms\Components\Section::make('Informasi Publik')
                    ->schema([
                        Forms\Components\Textarea::make('deskripsi'),
                        Forms\Components\Textarea::make('tujuan'),
                        Forms\Components\Textarea::make('prospek_karir'),
                    ])->columns(1),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nama_program_studi')->searchable(),
                Tables\Columns\TextColumn::make('kode_prodi'),
                Tables\Columns\TextColumn::make('jenjang'),
                Tables\Columns\TextColumn::make('gelar'),
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
            'index' => Pages\ListProgramStudis::route('/'),
            'create' => Pages\CreateProgramStudi::route('/create'),
            'edit' => Pages\EditProgramStudi::route('/{record}/edit'),
        ];
    }
}
