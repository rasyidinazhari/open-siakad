<?php

namespace App\Filament\Resources;

use App\Filament\Resources\KhsResource\Pages;
use App\Filament\Resources\KhsResource\RelationManagers;
use App\Models\Khs;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;

class KhsResource extends Resource
{
    protected static ?string $model = Khs::class;

    protected static ?string $navigationLabel = 'Data KHS';

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
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('mahasiswa.user.name')->label('Nama Mahasiswa')->searchable(),
                Tables\Columns\TextColumn::make('mahasiswa.nim')->label('NIM'),
                Tables\Columns\TextColumn::make('tahun_akademik.nama_tahun')->label('Tahun'),
                Tables\Columns\TextColumn::make('ips')->label('IPS (Semester)'),
                Tables\Columns\TextColumn::make('ipk')->label('IPK (Total)'),
                Tables\Columns\TextColumn::make('status')
                    ->label('Status KHS')
                    ->badge()
                    ->options([
                        'Draft' => 'Draft',
                        'Published' => 'Published',
                    ])
                    ->color(fn (string $state): string => $state === 'Published' ? 'success' : 'gray'),
            ])
            ->filters([
                // Filter untuk melihat IPK > 3 atau < 3 sesuai rencana [cite: 39]
                Tables\Filters\Filter::make('ipk_diatas_3')
                    ->query(fn ($query) => $query->where('ipk', '>=', 3.0)),
                Tables\Filters\Filter::make('ipk_dibawah_3')
                    ->query(fn ($query) => $query->where('ipk', '<', 3.0)),
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
            'index' => Pages\ListKhs::route('/'),
            'create' => Pages\CreateKhs::route('/create'),
            'edit' => Pages\EditKhs::route('/{record}/edit'),
        ];
    }
}
