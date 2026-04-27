🎓 SIAKAD PRO
=============

**Sistem Informasi Akademik & PMB Terintegrasi**

SIAKAD PRO adalah platform manajemen akademik modern yang mengintegrasikan proses **Penerimaan Mahasiswa Baru (PMB)**, **portal mahasiswa**, **portal dosen**, serta **manajemen administrasi** dalam satu sistem terpadu.

Dirancang dengan pendekatan modern, sistem ini memberikan pengalaman pengguna yang cepat, responsif, dan aman—termasuk dalam transaksi pembayaran.

🚀 Tech Stack
-------------

### 🧠 Backend & Core

*   **Framework:** Laravel (v10/11)
    
*   **Admin Panel:** Filament PHP (v3)
    
*   **Role & Permission:** Spatie Laravel Permission
    
*   **Payment Gateway:** Midtrans (Snap & Webhook)
    

### 🎨 Frontend

*   **Engine:** Inertia.js
    
*   **Framework:** Vue.js 3
    
*   **Styling:** Tailwind CSS
    
*   **Icons:** Google Material Icons
    

✨ Fitur Utama
-------------

### 🎓 PMB (Penerimaan Mahasiswa Baru)

*   Input biodata calon mahasiswa
    
*   Upload dokumen (KTP, KK, Ijazah, dll)
    
*   Pembayaran biaya pendaftaran terintegrasi Midtrans
    

### ⚙️ Otomatisasi Sistem

*   Generate NIM otomatis
    
*   Aktivasi mahasiswa setelah lolos seleksi
    
*   Perubahan role dari _Calon Mahasiswa_ → _Mahasiswa Aktif_
    

### 📚 Portal Mahasiswa

*   Pengajuan KRS
    
*   Monitoring KHS & IPK
    
*   Transkrip nilai
    
*   Informasi tagihan kuliah
    

### 👨‍🏫 Portal Dosen

*   Manajemen jadwal mengajar
    
*   Persetujuan KRS (perwalian)
    
*   Input nilai mahasiswa
    
*   Bimbingan Skripsi / Tugas Akhir
    

### 🔐 Keamanan Sistem

*   Validasi webhook Midtrans
    
*   Sinkronisasi status pembayaran real-time
    
*   Role-based access control (RBAC)
    

📦 Instalasi Proyek
-------------------

Ikuti langkah berikut untuk menjalankan proyek secara lokal:

### 1\. Persiapan Awal

Pastikan sudah terinstall:

*   PHP >= 8.1
    
*   Composer
    
*   Node.js & NPM
    
*   MySQL / MariaDB
    

### 2\. Clone Repository

```bash
git clone https://github.com/username-anda/nama-repo.gitcd nama-repo
```

### 3\. Install Dependency

```bash
composer installnpm install
```

### 4\. Konfigurasi Environment

```bash
cp .env.example .envphp artisan key:generate
```

Edit file .env:

```bash
DB_DATABASE=nama_database_andaDB_USERNAME=rootDB_PASSWORD=# Midtrans SandboxMIDTRANS_SERVER_KEY=SB-Mid-server-xxxxxxxxMIDTRANS_CLIENT_KEY=SB-Mid-client-xxxxxxxxMIDTRANS_IS_PRODUCTION=false
```

### 5\. Migrasi Database

```bash
php artisan migrate
```

### 6\. Storage Link

```bash
php artisan storage:link
```

### 7\. Jalankan Aplikasi

Buka 2 terminal:

**Terminal 1 (Backend)**

```bash
php artisan serve
```

**Terminal 2 (Frontend)**

```bash
npm run dev
```

Akses aplikasi:

```bash
http://127.0.0.1:8000
```

🛡️ Testing Webhook (Lokal)
---------------------------

Untuk menerima notifikasi dari Midtrans di localhost, gunakan **ngrok**:

```bash
ngrok http 8000
```

Gunakan URL HTTPS yang diberikan, lalu set di dashboard Midtrans:

```bash
https://xxxx-xxxx.ngrok-free.app/api/midtrans/webhook
```

📌 Catatan Pengembangan
-----------------------

*   Gunakan environment **sandbox** Midtrans untuk testing
    
*   Pastikan endpoint webhook dapat diakses publik
    
*   Validasi signature key untuk keamanan transaksi
    

❤️ Author
---------

Dibuat oleh:**Wisnu Rasyidin Azhari**
