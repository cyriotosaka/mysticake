## Deskripsi Proyek
Mysticake adalah aplikasi web berbasis Laravel 12 yang dirancang untuk mengakomodasi sistem jual-beli dessert dengan sistem Pre-Order (PO) yang dikombinasikan dengan fitur gamifikasi. Repositori ini dikembangkan dan digunakan sebagai studi kasus implementasi praktik DevOps pada mata kuliah Pengembangan Sistem Orientasi (PSO). Fokus utama pengerjaan pada fase ini adalah pembangunan infrastruktur otomatisasi terintegrasi yang mencakup standardisasi penulisan kode (linting), pengujian fungsional otomatis (automated testing), dan analisis kualitas serta keamanan kode statis melalui pipeline terpusat.

## Live Preview
Aplikasi Mysticake saat ini telah di-deploy secara mandiri dan dapat diakses secara publik melalui tautan berikut:
🔗 http://35.240.168.64/

## Product Description 

### 1.1.1	Latar belakang
Bisnis dessert dengan sistem Pre-Order (PO) menjadi salah salah satu tren usaha yang banyak digeluti karena lebih fleksibel, minim risiko, dan tidak membutuhkan modal besar untuk stok barang. Namun, dalam praktiknya masih terdapat berbagai permasalahan yang dialami baik penjual maupun pembeli.

Dari sisi penjual, permasalahan yang muncul antara lain kesulitan melakukan pembayaran di muka, ketersediaan bahan baku, serta strategi promosi yang masih terbatas dan kurang menarik bagi pelanggan. Hal ini berdampak pada rendahnya keterlibatan konsumen serta kurang efisiennya pengelolaan pesanan. Dari sisi pembeli, terdapat tantangan utama seperti keterbatasan waktu pemesanan, ketakutan tertinggal tren dessert viral, kekhawatiran pesanan tidak segera sampai, hingga kesulitan dalam perubahan pesanan yang masih dilakukan secara manual. Selain itu, ketidakjelasan biaya tambahan dan metode pembayaran yang tidak menentu semakin menurunkan kenyamanan bertransaksi.

Permasalahan-permasalahan tersebut menunjukkan bahwa masih ada gap yang cukup besar dalam sistem jual-beli dessert berbasis PO. Dibutuhkan sebuah solusi digital yang dapat mengakomodasi kebutuhan seller dalam promosi dan operasional, sekaligus memberikan pengalaman berbelanja yang nyaman, efisien, dan menyenangkan bagi buyer.

### 1.1.2	Tujuan
Oleh sebab itu, kami hendak mengembangkan sebuah aplikasi sistem jual-beli dessert berbasis PO bernama MystiCake dengan tujuan sebagai berikut:
* Membantu penjual dalam membuat dan mengelola konten promosi dengan template yang relevan dan menarik, sehingga penjual tidak perlu memikirkan ide promosi dari nol, memangkas waktu dan energi dalam proses kreatif, serta menjaga kualitas kontennya tetap menarik.
* Memberikan notifikasi real time kepada pembeli terkait jadwal pembukaan, penutupan, serta ketersediaan stok PO, sehingga pembeli tidak lagi khawatir ketinggalan informasi atau kehilangan kesempatan membeli dessert yang sedang tren.
* Menyediakan fitur pemesanan sederhana dengan alur yang jelas dan metode pembayaran yang fleksibel, sehingga, proses transaksi menjadi lebih praktis, transparan, dan nyaman bagi pembeli maupun penjual.

### 1.1.3	Manfaat
Dengan demikian, diharapkan bahwa:

**Bagi Penjual**
* Lebih mudah membuat promosi yang konsisten dan menarik
* Pengelolaan pesanan dan stok lebih efisien.
* Risiko kelebihan atau kekurangan stok dapat diminimalkan.

**Bagi Pembeli**
* Selalu update dengan informasi PO.
* Mendapatkan pengalaman pemesanan yang cepat, sederhana, dan menyenangkan.
* Memiliki pilihan metode pembayaran yang beragam dan jelas.

**Secara Umum:**
* Tercipta ekosistem transaksi PO yang modern, efisien, dan responsif.
* Pengalaman jual-beli menjadi lebih nyaman, menarik, dan berkesinambungan.

## Product Features

Aplikasi MystiCake memiliki beberapa fitur utama sebagai berikut

**Mystery Box Page (Regular & Premium)**
Fitur pembelian produk secara acak sesuai kategori masing-masing. Produk-produk terbagi ke berbagai kategori kelangkaan dengan persentase yang berbeda-beda. 

**Recommendation Page**
Halaman yang menampilkan produk-produk yang dipersonalisasi berdasarkan algoritma kebiasaan penjelajahan pengguna.

**Search Page**
Fitur pencarian produk atau toko menggunakan kata kunci tekstual masukan pengguna dengan hasil berbasis relevansi penamaan terdekat.

**Chat with Seller**
Fasilitas komunikasi langsung dua arah antara pembeli dan penjual yang mendukung pengiriman pesan teks, gambar, serta file lampiran.

**Cashback Bonus Page (After Mystery Box purchase)**
Halaman klaim reward berupa insentif cashback setelah pengguna berhasil melakukan transaksi pada Mystery Box.

**Profile & Setting Page**
Panel konfigurasi akun, data personal, preferensi aplikasi, dan pelacakan pencapaian gamifikasi pengguna.

**Product Page**
Halaman representasi detail produk, deskripsi komponen kue, harga, serta informasi sisa kuota PO.

**Shopping Cart Page**
Fasilitas penampungan produk sementara sebelum dilakukan proses checkout massal atau per unit.

**Topup Page**
Halaman transaksi untuk mengonversi dana tunai menjadi saldo mata uang internal aplikasi.

**Payment Page**
Gerbang pembayaran utama untuk menyelesaikan transaksi belanjaan menggunakan saldo akun pengguna.

**Gacha History Page**
Halaman log riwayat komprehensif atas pembelian Mystery Box dan hasil item yang didapatkan.

**Shopping History Page**
Dokumen riwayat pelacakan transaksi belanja konvensional dari pesanan yang pernah diproses.

**Rating Page**
Fitur umpan balik pasca-transaksi bagi pelanggan untuk memberikan penilaian berupa bintang dan ulasan tekstual pada produk.

## High-Level Functional Requirements

| Code | Fitur | Deskripsi |
| :--- | :--- | :--- |
| FR01 | Autentikasi | Sistem harus memungkinkan pengguna untuk membuat akun dan melakukan autentikasi (registrasi, login, logout). |
| FR02 | Katalog Produk | Sistem harus menyediakan katalog produk dessert yang dapat dilihat, dicari, dan difilter oleh pengguna. |
| FR03 | Manajemen Profil | Sistem harus memfasilitasi pengelolaan profil pengguna, termasuk riwayat pembelian dan pencapaian gamifikasi. |
| FR04 | Keranjang belanja | Sistem harus memungkinkan pengguna untuk mengelola keranjang belanja sebelum melakukan checkout. |
| FR05 | Gamifikasi Gacha | Sistem harus menyediakan fitur gamifikasi gacha yang memberikan dessert spesial, diskon, atau hadiah virtual sebagai bentuk reward. |
| FR06 | Penukaran Hadiah | Sistem harus memungkinkan pengguna untuk menukarkan hadiah gacha dengan produk atau voucher sesuai ketentuan. |
| FR07 | Sistem Notifikasi | Sistem harus menyediakan notifikasi terkait status pesanan, promosi, atau hasil gacha. |
| FR08 | Panel Admin | Sistem harus memberikan akses bagi admin untuk mengelola produk dessert, termasuk stok, harga, dan deskripsi. |
| FR09 | Laporan Penjualan | Sistem harus menyediakan laporan penjualan dan aktivitas gacha bagi admin untuk mendukung pengambilan keputusan. |
| FR10 | Ulasan dan Rating | Sistem harus mendukung ulasan dan rating pengguna terhadap dessert untuk meningkatkan kepercayaan dan pengalaman pengguna. |
| FR11 | Keamanan Data | Sistem harus menjamin keamanan transaksi dan data pengguna melalui enkripsi dan manajemen hak akses. |
| FR12 | Mystery Box Page (Regular & Premium) | Sistem harus menyediakan halaman Mystery Box (Regular dan Premium) yang memungkinkan pengguna melakukan pembelian dengan mudah. |
| FR13 | Recommendation Page | Sistem harus menampilkan rekomendasi produk yang relevan untuk meningkatkan keterlibatan dan penjualan. |
| FR14 | Search Page | Sistem harus memungkinkan pengguna mencari produk berdasarkan kata kunci atau kategori agar memudahkan pencarian. |
| FR15 | Chat with Seller | Sistem harus memfasilitasi komunikasi langsung antara pembeli dan penjual melalui fitur chat. |
| FR16 | Cashback Bonus Page (After Mystery Box purchase) | Sistem harus memberikan informasi cashback kepada pengguna setelah pembelian Mystery Box untuk meningkatkan loyalitas. |
| FR17 | Profile & Setting Page | Sistem harus mengizinkan pengguna mengelola profil dan pengaturan akun sesuai kebutuhan mereka. |
| FR18 | Product Page | Sistem harus menyediakan halaman detail produk untuk membantu pengguna membuat keputusan pembelian. |
| FR19 | Shopping Cart Page | Sistem harus memfasilitasi pengguna dalam meninjau, mengubah, dan melanjutkan pesanan sebelum pembayaran. |
| FR20 | Topup Page | Sistem harus memungkinkan pengguna melakukan top-up saldo agar dapat digunakan untuk transaksi |
| FR21 | Payment Page | Sistem harus menyediakan berbagai metode pembayaran untuk mendukung kelancaran transaksi. |
| FR22 | Gacha History Page | Sistem harus menampilkan riwayat pembelian Mystery Box agar pengguna dapat meninjau hasil transaksi sebelumnya. |
| FR23 | Shopping History Page | Sistem harus menyimpan dan menampilkan riwayat belanja pengguna untuk memudahkan pelacakan transaksi. |
| FR24 | Rating Page | Sistem harus menyediakan fitur penilaian dan ulasan agar pengguna dapat memberikan feedback terhadap produk. |

### Nick Name Akun Github
| Nama Akun | Nama Lengkap | NRP    | Tanggung Jawab |
| :--- | :--- | :--- | :--- |
| zahrarfin27 | Azzahra Amalia Arfin | 5026231026 | Documentation & Logic: Penyusunan log laporan pasca-insiden (post-mortem), pembuatan manual panduan pengguna, dan audit logika integrasi |
| angelasiuli | Beh Siu Li | 5026231065 | Lead Infrastructure (CI): Konfigurasi pipeline utama pada GitHub Actions dan penyusunan integrasi otomasi pengujian linting |
| cyriotosaka | Okky Priscila Putri | 5026231168 | Quality Assurance (QA): Setup proyek di SonarQube Cloud, perbaikan code smell, dan analisis kerentanan statis |
| sahilah | Sahilah Amru Yumnatusta | 5026231182 | Deployment & Env: Manajemen sinkronisasi variabel, penataan Continuous Deployment (CD), dan optimalisasi server |

---

## Tech Stack

| Tech Stack | Technology | Version |
|------------|---------|
| Language | PHP | 8.4+ |
| Framework | Laravel | 12.x |
| Database | MySQL | 8.0+ |
| Frontend | Bootstrap | 5.3 |
| Frontend | Node.js | 18+ (untuk assets) |
| Dependency Manager | Composer | 2.x |

---

## Dokumentasi Proyek DevOps (7 Tahapan):
Proyek ini diselesaikan melalui tujuh tahapan seperti berikut:

**1. Migrasi Repositori**
Memindahkan basis kode dari repositori lama (berstatus forking yang membatasi hak visibilitas publik) menuju repositori mandiri baru agar proses asesmen oleh tim Asisten Laboratorium dapat diakses secara terbuka.

**2. Linting Check and Automation**
Mengintegrasikan sistem pengecekan standardisasi kode. Pada inisialisasi awal, pipa integrasi mengalami kegagalan (failed), yang kemudian berhasil distabilkan secara permanen memanfaatkan perintah otomatisasi laravel lint:fix (Laravel Pint).

**3. Pest Testing Integration**
Menyusun kerangka kerja unit pengujian fungsional berbasis Pest. Skrip pengujian dikonfigurasi  ketat untuk mengabaikan/bypass database migration demi menjaga integritas data dan kecepatan eksekusi integrasi di server.

**4. Optimasi Code Coverage**
Melakukan pelacakan persentase cakupan kode (code coverage) lokal untuk memastikan unit logika kritis pada komponen Model telah teruji dengan baik.

**5. Koneksi SonarQube Cloud**
Mengintegrasikan repositori proyek dengan ekosistem SonarQube Cloud via OAuth GitHub guna memantau indeks keamanan, duplikasi kode (DRY principle), dan keandalan kode secara berkala.

**6. Penyusunan Ulang Alur CI/CD**
Merestrukturisasi berkas deklarasi alur kerja .github/workflows/*.yml agar fungsionalitas otomasi pengujian terisolasi dapat berjalan tanpa hambatan database fisik.

**7. Uji Validasi Akhir (Pipeline Test)**
Melakukan simulasi siklus hidup rilis (push dan pull request) untuk memverifikasi kelulusan status (Passed) di seluruh indikator gerbang kualitas (Quality Gate).

---

## Log Masalah dan Solusi (Post-Mortem Log)

**1. SonarQube CI Automation Clash**
Fitur analisis otomatis bawaan (Automatic Analysis) pada platform SonarQube Cloud bertabrakan dengan skrip analisis manual yang dideklarasikan pada GitHub Actions kelompok. Solusinya adalah dengan menonaktifkan (toggle off) opsi Automatic Analysis dari dashboard proyek SonarQube Cloud, sehingga kontrol eksekusi sepenuhnya diberikan ke GitHub Actions.

**2. Pest Migration Dependency Failures**
Automated testing gagal berjalan di server CI karena mencoba memanggil berkas migrasi database memori secara default. Dengan menyesuaikan file konfigurasi testing dan mematikan fungsi instruksi RefreshDatabase pada berkas tes fungsional, memastikan proses pengujian murni memvalidasi fungsionalitas logika internal model tanpa menyentuh database eksternal.

---

## Installation / Setup Guide

### System Requirements
- PHP >= 8.4
- Composer >= 2.0
- MySQL >= 8.0
- Node.js >= 18 (optional, untuk compile assets)
- Git

### Langkah Instalasi

**1. Clone Repository**
```bash
git clone https://github.com/AbdulGhoni109/final-project-mysticake-PPPL8-C.git
cd final-project-mysticake-PPPL8-C
```

**2. Install Dependencies**
```bash
composer install
npm install
```

**3. Setup Environment**
```bash
cp .env.example .env
php artisan key:generate
```

**4. Konfigurasi Database**

Edit file `.env` dan sesuaikan konfigurasi database:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=mysticakedb
DB_USERNAME=root
DB_PASSWORD=your_password

SESSION_DRIVER=file
SESSION_LIFETIME=120
SESSION_ENCRYPT=false
SESSION_PATH=/
SESSION_DOMAIN=null
```

**5. Setup Database**
```bash
# Buat database di MySQL
mysql -u root -p -e "CREATE DATABASE mysticakedb;"

# Import database (gunakan file SQL yang tersedia)
mysql -u root -p mysticakedb < database/mysticakedb\ \(1\).sql

# Atau jalankan migration
php artisan migrate
```

**6. Jalankan Aplikasi**
```bash
php artisan serve
```

Akses aplikasi di: **http://35.240.168.64/**

---

## Folder Structure

```
final-project-mysticake-PPPL8-C/
├── app/                          # Core Application
│   ├── Http/
│   │   ├── Controllers/          # Controllers (ProductController, CartController, dll)
│   │   └── Middleware/           # HTTP Middlewares
│   ├── Models/                   # Eloquent Models (Product, User, Orders, dll)
│   └── Providers/                # Service Providers
│
├── bootstrap/                    # Framework Bootstrap Files
│
├── config/                       # Configuration Files
│   ├── app.php                   # Application Config
│   ├── database.php              # Database Config
│   └── ...
│
├── database/                     # Database Files
│   ├── migrations/               # Database Migrations
│   ├── seeders/                  # Database Seeders
│   └── mysticakedb (1).sql       # SQL Dump File
│
├── docs/                         # Documentation
│   ├── SCRIPT_DEMO_3_USE_CASE.md # Demo Script
│   ├── SCRIPT_VIDEO_PRESENTASI.md
│   └── USE_CASE_PENCARIAN_PRODUK.md
│
├── public/                       # Public Assets
│   ├── css/                      # Stylesheets
│   │   ├── home.css
│   │   ├── search.css
│   │   ├── rating.css
│   │   ├── product.css
│   │   └── ...
│   ├── images/                   # Image Assets
│   │   ├── products/             # Product Images
│   │   └── reviews/              # Review Photos
│   └── index.php                 # Entry Point
│
├── resources/                    # Resources
│   └── views/                    # Blade Templates
│       ├── home.blade.php        # Home Page
│       ├── cart/                 # Cart Views
│       ├── order/                # Order/Checkout Views
│       ├── product/              # Product Views
│       ├── rating/               # Rating Views
│       ├── search/               # Search Views
│       ├── settings/             # Settings Views
│       └── partials/             # Partial Components
│
├── routes/                       # Route Definitions
│   ├── web.php                   # Web Routes
│   └── console.php               # Console Routes
│
├── storage/                      # Storage Files
│   ├── app/                      # Application Storage
│   ├── framework/                # Framework Storage
│   └── logs/                     # Log Files
│
├── tests/                        # Test Files
│
├── .env                          # Environment Variables
├── .env.example                  # Environment Example
├── composer.json                 # PHP Dependencies
├── package.json                  # Node Dependencies
└── README.md                     # This File
```

---

## License

This project is developed for educational purposes as part of PSO (Pengembangan Sistem Orientasi) and PPPL (Pengembangan Perangkat Lunak Profesional) courses at Institut Teknologi Sepuluh Nopember (ITS) Surabaya. All core frameworks are covered under the open-source MIT License.
