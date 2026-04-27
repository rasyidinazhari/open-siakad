<?php

namespace App\Filament\Resources;

use App\Filament\Resources\KrsResource\Pages;
use App\Filament\Resources\KrsResource\RelationManagers;
use App\Models\Krs;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Filament\Tables\Actions\BulkAction;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;

class KrsResource extends Resource
{
    protected static ?string $model = Krs::class;

    protected static ?string $navigationLabel = 'Data KRS';

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = 'Transaksi Akademik';

    public static function canViewAny(): bool
    {
        return Auth::user()->can('akses_akademik') || Auth::user()->hasRole('Web Administrator');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Form Input KRS Baru')
                    ->schema([
                        Forms\Components\Select::make('mahasiswa_id')
                            ->relationship('mahasiswa', 'nim', modifyQueryUsing: fn ($query) => $query->join('users', 'mahasiswas.user_id', '=', 'users.id')->select('mahasiswas.*', 'users.name'))
                            ->getOptionLabelFromRecordUsing(fn ($record) => "{$record->user->name} ({$record->nim})")
                            ->searchable()
                            ->required(),
                        Forms\Components\Select::make('tahun_akademik_id')
                            ->relationship('tahun_akademik', 'nama_tahun')
                            ->required(),
                        Forms\Components\TextInput::make('semester')
                            ->numeric()
                            ->required(),
                        Forms\Components\Select::make('dosen_wali_id')
                            ->label('Dosen Wali')
                            ->relationship('dosen_wali', 'name', modifyQueryUsing: fn ($query) => $query->join('users', 'dosens.user_id', '=', 'users.id')->select('dosens.*', 'users.name'))
                            ->searchable()
                            ->required(),
                        Forms\Components\Textarea::make('catatan')
                            ->columnSpanFull(),
                    ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('mahasiswa.user.name')
                    ->label('Nama Mahasiswa')
                    // Menampilkan NIM di bawah nama sesuai permintaan [cite: 33]
                    ->description(fn ($record): string => $record->mahasiswa->nim)
                    ->searchable(),
                Tables\Columns\TextColumn::make('tahun_akademik.nama_tahun')->label('Tahun Akademik'),
                Tables\Columns\TextColumn::make('semester')->label('Smstr'),
                Tables\Columns\TextColumn::make('total_sks')->label('Total SKS')->default(0),
                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'Pending' => 'warning',
                        'Approved' => 'success',
                        'Rejected' => 'danger',
                        default => 'gray',
                    }),
                Tables\Columns\TextColumn::make('created_at')->label('Tanggal Dibuat')->dateTime(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    // Fitur Approve Terpilih secara bersamaan [cite: 34]
                    BulkAction::make('approve_terpilih')
                        ->label('Approve Terpilih')
                        ->icon('heroicon-o-check-circle')
                        ->color('success')
                        ->requiresConfirmation()
                        ->action(fn (Collection $records) => $records->each->update(['status' => 'Approved'])),
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
            'index' => Pages\ListKrs::route('/'),
            'create' => Pages\CreateKrs::route('/create'),
            'edit' => Pages\EditKrs::route('/{record}/edit'),
        ];
    }
}
