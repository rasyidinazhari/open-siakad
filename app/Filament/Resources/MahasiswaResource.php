<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MahasiswaResource\Pages;
use App\Filament\Resources\MahasiswaResource\RelationManagers;
use App\Models\Mahasiswa;
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
use Filament\Tables\Actions\Action;
use Filament\Notifications\Notification;
use App\Models\PembayaranPmb;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\BadgeColumn;

class MahasiswaResource extends Resource
{
    protected static ?string $model = Mahasiswa::class;

    protected static ?string $navigationLabel = 'Data Mahasiswa';

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = 'Akun dan Pengguna'; // [cite: 98]

    public static function canViewAny(): bool
    {
        return Auth::user()->can('akses_kemahasiswaan') || Auth::user()->can('akses_akademik') || Auth::user()->hasRole('Web Administrator'); // [cite: 101, 102, 104]
    }

    public static function form(Form $form): Form
    {
        return $form->schema([
            Section::make('Informasi Akademik')
                ->description('Data resmi perguruan tinggi')
                ->schema([
                    Select::make('user_id')
                        ->relationship('user', 'name')
                        ->required()
                        ->searchable(),
                    TextInput::make('nim')
                        ->label('NIM')
                        ->required()
                        ->unique(ignoreRecord: true),
                    Select::make('program_studi_id')
                        ->relationship('program_studi', 'nama_program_studi')
                        ->required(),
                    Select::make('status_mahasiswa')
                        ->options([
                            'Aktif' => 'Aktif',
                            'Cuti' => 'Cuti',
                            'Lulus' => 'Lulus',
                            'Drop Out' => 'Drop Out',
                        ])
                        ->required(),
                ])->columns(2),

            Section::make('Biodata Pribadi')
                ->description('Data diri hasil sinkronisasi dari PMB')
                ->schema([
                    TextInput::make('nik')
                        ->label('NIK')
                        ->maxLength(16)
                        ->numeric(),
                    Select::make('jenis_kelamin')
                        ->options([
                            'Laki-laki' => 'Laki-laki',
                            'Perempuan' => 'Perempuan',
                        ]),
                    TextInput::make('tempat_lahir'),
                    DatePicker::make('tanggal_lahir'),
                    TextInput::make('asal_sekolah')
                        ->label('Asal Sekolah Menengah'),
                    Textarea::make('alamat_lengkap')
                        ->columnSpanFull(),
                ])->columns(2)
                ->collapsed(), // Dibuat bisa di-collapse (buka-tutup) agar form tidak terlalu panjang
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user.name')
                    ->label('Nama')
                    ->searchable(),
                Tables\Columns\TextColumn::make('nim')
                    ->label('NIM')
                    ->placeholder('Belum Terbit')
                    ->searchable(),
                Tables\Columns\TextColumn::make('program_studi.nama_program_studi')
                    ->label('Prodi'),
                
                // Indikator Pembayaran (Dipertahankan & Dioptimasi)
                Tables\Columns\TextColumn::make('pembayaran_status')
                    ->label('Pembayaran')
                    ->getStateUsing(function ($record) {
                        // Cek relasi pembayaran yang statusnya Lunas
                        return $record->pembayaran->where('status', 'Lunas')->first() ? 'Lunas' : 'Belum Lunas';
                    })
                    ->badge()
                    ->color(fn ($state) => $state === 'Lunas' ? 'success' : 'danger'),

                // Status Mahasiswa (Dipertahankan)
                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'Mahasiswa Aktif' => 'success',
                        'Calon Mahasiswa Baru' => 'warning',
                        'Mahasiswa Non Aktif' => 'danger',
                        default => 'gray',
                    }),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'Calon Mahasiswa Baru' => 'Calon MHS',
                        'Mahasiswa Aktif' => 'Aktif',
                        'Mahasiswa Non Aktif' => 'Non Aktif',
                    ]),
                Tables\Filters\SelectFilter::make('program_studi_id')
                    ->relationship('program_studi', 'nama_program_studi')
                    ->label('Filter Prodi'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                
                // Tombol Verifikasi (Dipertahankan dengan Enhance Notifikasi)
                Action::make('verifikasi')
                    ->label('Verifikasi & Terbitkan NIM')
                    ->icon('heroicon-o-check-badge')
                    ->color('success')
                    ->visible(fn ($record) => $record->status === 'Calon Mahasiswa Baru')
                    ->requiresConfirmation()
                    ->modalHeading('Verifikasi Mahasiswa Baru')
                    ->modalDescription('Pastikan pembayaran sudah lunas sebelum menerbitkan NIM.')
                    ->action(function ($record) {
                        $pembayaran = $record->pembayaran()->where('status', 'Lunas')->first();

                        if (!$pembayaran) {
                            Notification::make()
                                ->title('Gagal Verifikasi')
                                ->body('Calon mahasiswa belum melakukan pelunasan biaya pendaftaran.')
                                ->danger()
                                ->send();
                            return;
                        }

                        $nimBaru = $record->generateNim();
                        $record->update([
                            'nim' => $nimBaru,
                            'status' => 'Mahasiswa Aktif',
                            'semester' => 1,
                        ]);

                        $user = $record->user;
                        $user->removeRole('Calon Mahasiswa');
                        $user->assignRole('Mahasiswa');

                        Notification::make()
                            ->title('Berhasil!')
                            ->body("Mahasiswa terverifikasi dengan NIM: $nimBaru")
                            ->success()
                            ->send();
                    }),
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
            'index' => Pages\ListMahasiswas::route('/'),
            'create' => Pages\CreateMahasiswa::route('/create'),
            'edit' => Pages\EditMahasiswa::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        // Eager load user, prodi, dan pembayaran untuk performa tabel yang cepat
        return parent::getEloquentQuery()->with(['user', 'program_studi', 'pembayaran']);
    }
}
