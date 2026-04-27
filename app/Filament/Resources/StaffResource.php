<?php

namespace App\Filament\Resources;

use App\Filament\Resources\StaffResource\Pages;
use App\Filament\Resources\StaffResource\RelationManagers;
use App\Models\Staff;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class StaffResource extends Resource
{
    protected static ?string $model = Staff::class;

    protected static ?string $navigationLabel = 'Data Staff';

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = 'Akun dan Pengguna'; // [cite: 98]

    public static function canViewAny(): bool
    {
        return Auth::user()->hasRole('Web Administrator'); // 
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Informasi Akun Staff')
                    ->schema([
                        // Field User Dasar
                        Forms\Components\TextInput::make('name')
                            ->label('Nama Lengkap')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('email')
                            ->email()
                            ->required()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('nomor_telepon')
                            ->tel()
                            ->maxLength(20),
                        Forms\Components\TextInput::make('password')
                            ->password()
                            ->dehydrateStateUsing(fn ($state) => Hash::make($state))
                            ->dehydrated(fn ($state) => filled($state))
                            ->required(fn (string $context): bool => $context === 'create'),
                        
                        // Dropdown Departemen sesuai dokumen
                        Forms\Components\Select::make('departement')
                            ->options([
                                'Web Administrator' => 'Web Administrator',
                                'Akademik' => 'Departement Akademik',
                                'Keuangan' => 'Departement Keuangan',
                                'Kemahasiswaan' => 'Departement Kemahasiswaan',
                                'Perpustakaan' => 'Departement Perpustakaan',
                                'Infrastruktur & IT' => 'Departement Infrastruktur & IT',
                                'Admisi' => 'Departement Admisi',
                                'Umum' => 'Departement Umum',
                            ])->required(),
                    ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                // 1. Ambil Nama dari relasi User
                Tables\Columns\TextColumn::make('user.name')
                    ->label('Nama Lengkap')
                    ->searchable()
                    ->sortable(),

                // 2. Ambil Email dari relasi User
                Tables\Columns\TextColumn::make('user.email')
                    ->label('Email')
                    ->searchable(),

                // 3. Nomor Telepon (ada di tabel staffs)
                Tables\Columns\TextColumn::make('nomor_telepon')
                    ->label('No. Telp')
                    ->toggleable(),

                // 4. Departemen dengan Badge agar rapi
                Tables\Columns\TextColumn::make('departement')
                    ->label('Departemen')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'Web Administrator' => 'danger',
                        'Akademik' => 'success',
                        'Keuangan' => 'warning',
                        default => 'info',
                    })
                    ->sortable(),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Terdaftar Pada')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                // Tambahkan filter departemen agar mudah mencari
                Tables\Filters\SelectFilter::make('departement')
                    ->options([
                        'Web Administrator' => 'Web Administrator',
                        'Akademik' => 'Akademik',
                        'Keuangan' => 'Keuangan',
                        'Kemahasiswaan' => 'Kemahasiswaan',
                        'Perpustakaan' => 'Perpustakaan',
                        'Infrastruktur & IT' => 'Infrastruktur & IT',
                        'Admisi' => 'Admisi',
                        'Umum' => 'Umum',
                    ]),
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
            'index' => Pages\ListStaff::route('/'),
            'create' => Pages\CreateStaff::route('/create'),
            'edit' => Pages\EditStaff::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->with('user');
    }

}
