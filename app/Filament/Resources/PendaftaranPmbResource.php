<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PendaftaranPmbResource\Pages;
use App\Filament\Resources\PendaftaranPmbResource\RelationManagers;
use App\Models\PendaftaranPmb;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\FileUpload;
use Filament\Tables\Actions\Action;
use Illuminate\Support\Facades\DB;
use App\Models\Mahasiswa;
use App\Models\User;
use Illuminate\Support\Facades\Auth;


class PendaftaranPmbResource extends Resource
{
    protected static ?string $model = PendaftaranPmb::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = 'PMB / Admisi';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Section::make('Status Kelulusan & Verifikasi')->schema([
                Select::make('status_lulus')
                    ->options([
                        'Pending' => 'Pending / Sedang Diproses',
                        'Lulus' => 'Lulus',
                        'Tidak Lulus' => 'Tidak Lulus',
                    ])
                    ->required(),
                Select::make('status_pembayaran')
                    ->options([
                        'Belum Lunas' => 'Belum Lunas',
                        'Lunas' => 'Lunas',
                    ])
                    ->required(),
            ])->columns(2),

            Section::make('Dokumen Pendaftar')->schema([
                FileUpload::make('path_foto')->label('Pas Foto')->directory('pmb/berkas')->openable(),
                FileUpload::make('path_ijazah')->label('Ijazah')->directory('pmb/berkas')->openable(),
                FileUpload::make('path_kk')->label('Kartu Keluarga')->directory('pmb/berkas')->openable(),
                FileUpload::make('path_ktp')->label('KTP')->directory('pmb/berkas')->openable(),
            ])->columns(2),
            
            Section::make('Biodata Diri')->schema([
                TextInput::make('nik')->label('NIK')->disabled(),
                TextInput::make('tempat_lahir')->disabled(),
                TextInput::make('asal_sekolah')->disabled(),
            ])->columns(3),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            Tables\Columns\TextColumn::make('user.name')->label('Nama Pendaftar')->searchable(),
            Tables\Columns\TextColumn::make('nik')->label('NIK')->searchable(),
            Tables\Columns\TextColumn::make('asal_sekolah')->label('Asal Sekolah'),
            Tables\Columns\BadgeColumn::make('status_pembayaran')
                ->colors([
                    'danger' => 'Belum Lunas',
                    'success' => 'Lunas',
                ]),
            Tables\Columns\BadgeColumn::make('status_lulus')
                ->colors([
                    'warning' => 'Pending',
                    'success' => 'Lulus',
                    'danger' => 'Tidak Lulus',
                ]),
        ])
        ->filters([
            Tables\Filters\SelectFilter::make('status_lulus')->options([
                'Pending' => 'Pending',
                'Lulus' => 'Lulus',
                'Tidak Lulus' => 'Tidak Lulus',
            ]),
        ])
        ->actions([
            Tables\Actions\EditAction::make(),
            Action::make('Aktivasi Mahasiswa')
                ->icon('heroicon-o-check-badge')
                ->color('success')
                ->requiresConfirmation()
                ->visible(fn ($record) => $record->status_lulus === 'Lulus' && $record->status_pembayaran === 'Lunas')
                ->action(function ($record) {
                    DB::transaction(function () use ($record) {
                        // 1. Generate NIM (Contoh: 2401001)
                        $tahun = date('y'); 
                        $prodi = "01"; // Bisa dinamis dari prodi yang dipilih
                        $count = Mahasiswa::count() + 1;
                        $nim = $tahun . $prodi . str_pad($count, 3, '0', STR_PAD_LEFT);

                        // 2. Buat data di tabel Mahasiswa beserta lemparan Biodata dari PMB
                    Mahasiswa::create([
                        'user_id' => $record->user_id,
                        'nim' => $nim,
                        'program_studi_id' => 1, // Atau ambil dari data pendaftaran jika ada
                        'status_mahasiswa' => 'Aktif',
                        'nik' => $record->nik,
                        'tempat_lahir' => $record->tempat_lahir,
                        'tanggal_lahir' => $record->tanggal_lahir,
                        'jenis_kelamin' => $record->jenis_kelamin,
                        'alamat_lengkap' => $record->alamat_lengkap,
                        'asal_sekolah' => $record->asal_sekolah,
                    ]);

                        // 3. Update Role User
                        $user = User::find($record->user_id);
                        $user->removeRole('Calon Mahasiswa');
                        $user->assignRole('Mahasiswa');
                        
                        // 4. Tandai pendaftaran sudah diproses (Opsional: hapus atau beri flag)
                        $record->delete(); 
                    });
                })
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
            'index' => Pages\ListPendaftaranPmbs::route('/'),
            'create' => Pages\CreatePendaftaranPmb::route('/create'),
            'edit' => Pages\EditPendaftaranPmb::route('/{record}/edit'),
        ];
    }
}
