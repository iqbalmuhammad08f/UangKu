## UangKu - Aplikasi Manajemen Dompet Digital

**UangKu** adalah aplikasi web manajemen dompet digital (digital wallet) yang dibangun menggunakan **Laravel 12** dan **Tailwind CSS**. Aplikasi ini dirancang untuk membantu pengguna dalam mengelola keuangan pribadi mereka secara digital dan efisien.

### Tujuan Project

Aplikasi ini bertujuan untuk menyediakan platform yang user-friendly bagi pengguna untuk:

-   Mengelola saldo dompet mereka
-   Mencatat setiap transaksi (pemasukan dan pengeluaran)
-   Mengorganisir transaksi berdasarkan kategori
-   Melacak riwayat keuangan mereka
-   Menjaga keamanan data finansial dengan sistem autentikasi yang kuat

## ✨ Fitur Utama

### 1. **Autentikasi Pengguna**

-   Registrasi akun baru
-   Login dengan email dan password
-   Fitur lupa password dengan reset token
-   Keamanan password dengan enkripsi

### 2. **Manajemen Dompet (Wallet)**

-   Membuat dan mengelola dompet digital
-   Melihat saldo terkini
-   Melacak perubahan saldo dari transaksi

### 3. **Manajemen Transaksi**

-   Menambah transaksi baru (pemasukan/pengeluaran)
-   Melihat riwayat transaksi lengkap
-   Update dan hapus transaksi
-   Filter berdasarkan kategori
-   Melihat detail transaksi

### 4. **Kategori Transaksi**

-   Sistem kategorisasi transaksi yang fleksibel
-   Kategori yang dapat dikustomisasi
-   Membantu pengguna mengorganisir transaksi lebih baik

### 5. **Dashboard**

-   Ringkasan informasi keuangan
-   Statistik transaksi
-   Interface yang intuitif dan responsif

### 6. **Profil Pengguna**

-   Mengelola informasi profil
-   Mengubah password
-   Pengaturan akun

## 💻 Persyaratan Sistem

Sebelum menginstal project ini, pastikan sistem Anda memiliki:

### Backend Requirements

-   **PHP** >= 8.2
-   **Composer** (PHP Package Manager)
-   **Laravel Framework** 12.0+

### Frontend Requirements

-   **Node.js** >= 16.x
-   **npm** atau **yarn**

### Database

-   **MySQL** 8.0+ atau **SQLite**

### Web Server

-   **Apache** dengan mod_rewrite
-   atau **Nginx**

## 📦 Instalasi

Ikuti langkah-langkah di bawah ini untuk menginstal project:

### Step 1: Clone Repository

```bash
git clone https://github.com/iqbalmuhammad08f/UangKu.git
cd projek-akhir-pweb
```

### Step 2: Install Dependency PHP

```bash
composer install
```

### Step 3: Setup Environment File

Buat file `.env` dengan menyalin dari file `.env.example`:

```bash
cp .env.example .env
```

### Step 4: Generate Application Key

```bash
php artisan key:generate
```

### Step 5: Konfigurasi Database

Edit file `.env` dan sesuaikan konfigurasi database Anda:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=uangku
DB_USERNAME=root
DB_PASSWORD=
```

### Step 6: Jalankan Migration Database

```bash
php artisan migrate
```

### Step 7: Jalankan Seeder (Opsional)

Untuk mengisi database dengan data dummy:

```bash
php artisan db:seed
```

Atau jalankan seeder spesifik:

```bash
php artisan db:seed --class=CategorySeeder
php artisan db:seed --class=DummyUserSeeder
```

### Step 8: Install Dependency NPM

```bash
npm install
```

## ⚙️ Konfigurasi

### Konfigurasi Aplikasi

Edit file `config/app.php` untuk mengatur:

-   Nama aplikasi
-   Timezone
-   Locale (bahasa)

### Konfigurasi Database

Pastikan file `.env` sudah dikonfigurasi dengan benar sesuai dengan database lokal Anda.

### Konfigurasi Mail (Untuk Reset Password)

Jika ingin menggunakan fitur reset password dengan email, konfigurasi mail di `.env`:

```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=your_username
MAIL_PASSWORD=your_password
MAIL_FROM_ADDRESS=noreply@uangku.com
MAIL_FROM_NAME="UangKu"
```

## 🚀 Menjalankan Project

### Cara 1: Development Mode (Recommended)

Jalankan semua service sekaligus (server, queue, logs, dan Vite):

```bash
composer run dev
```

Perintah ini akan menjalankan:

-   Laravel Development Server (http://localhost:8000)
-   Queue Listener
-   Log Pail
-   Vite Development Server (untuk hot module reloading)

### Cara 2: Manual - Jalankan Setiap Service Terpisah

**Terminal 1 - Laravel Server:**

```bash
php artisan serve
```

**Terminal 2 - Frontend Development:**

```bash
npm run dev
```

**Terminal 3 - Queue Listener (Opsional):**

```bash
php artisan queue:listen --tries=1
```

**Terminal 4 - View Logs (Opsional):**

```bash
php artisan pail --timeout=0
```

### Akses Aplikasi

Buka browser dan akses:

```
http://localhost:8000
```

### Kompilasi Production

Untuk membuat build production:

```bash
npm run build
```

## 📁 Struktur Project

```
projek-akhir-pweb/
├── app/
│   ├── Http/
│   │   └── Controllers/        # Controller untuk handle logic
│   └── Models/                 # Model database (User, Wallet, Transaction, Category)
├── database/
│   ├── migrations/            # File migrasi database
│   ├── seeders/               # File seeder untuk data dummy
│   └── factories/             # Factory untuk testing
├── resources/
│   ├── css/                   # File CSS (Tailwind)
│   ├── js/                    # File JavaScript
│   └── views/                 # Blade template files
├── routes/
│   └── web.php                # Routing aplikasi
├── config/                    # File konfigurasi
├── public/                    # File publik (assets, index.php)
├── storage/                   # Folder untuk menyimpan logs dan cache
├── tests/                     # File testing
├── composer.json              # PHP dependencies
├── package.json               # Node dependencies
└── .env                       # Environment variables (jangan commit)
```

## 📝 Catatan Penting

-   File `.env` jangan di-commit ke repository
-   Selalu jalankan `composer install` dan `npm install` setelah pull code terbaru
-   Gunakan `php artisan migrate` untuk update database schema
-   Untuk development, gunakan command `composer run dev`

## 👤 Author

Dikembangkan oleh: **iqbalmuhammad08f**

## 📄 Lisensi

Project ini dilisensikan di bawah [MIT license](https://opensource.org/licenses/MIT) - lihat file LICENSE untuk detail.

---
