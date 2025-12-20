<!--
    Nama: Abdul Ghoni
    NRP: 5026231109
    Updated by Abdul Ghoni (5026231109) - Menambahkan step migration dan info fitur Review Photo
-->

# MystiCake - Setup Instructions

## Prerequisites
- PHP >= 8.1
- MySQL/MariaDB
- Composer
- Laravel >= 10.x

## Setup Steps

### 1. Clone/Pull the Repository
```bash
git pull origin main
```

### 2. Install Dependencies
```bash
composer install
```

### 3. Configure Environment
Copy `.env.example` to `.env` and configure your database:
```bash
cp .env.example .env
```

Edit `.env` file:
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=mysticakedb
DB_USERNAME=root
DB_PASSWORD=your_password
```

### 4. Import Database
Import the SQL file located at `database/mysticakedb (1).sql`:

**Option 1: Using MySQL Command Line**
```bash
mysql -u root -p -e "CREATE DATABASE IF NOT EXISTS mysticakedb;"
mysql -u root -p mysticakedb < database/mysticakedb\ \(1\).sql
```

**Option 2: Using phpMyAdmin**
1. Open phpMyAdmin
2. Create database named `mysticakedb`
3. Import `database/mysticakedb (1).sql`

### 5. Generate Application Key
```bash
php artisan key:generate
```

### 6. Run Migrations (PENTING!)
Setelah import database, jalankan migration untuk update struktur database terbaru:
```bash
php artisan migrate
```

> ⚠️ **PENTING**: Langkah ini wajib dilakukan setiap kali pull kode terbaru untuk menyinkronkan perubahan database!

### 7. Run the Application
```bash
php artisan serve
```

The application will be available at: `http://localhost:8000`

## Recent Updates

### Review Photo Feature (Terbaru!)
Fitur baru pada halaman rating/review produk:
- Upload foto saat memberikan review
- Lihat foto review dalam lightbox ukuran besar
- Edit dan hapus review (CRUD lengkap)
- Filter review berdasarkan rating dan "With Photos"

**Migration terkait:** `2025_12_20_091500_add_photo_to_review_product_table.php`

### Delivery Options
The system now includes 4 delivery options:
- Motor (Rp 10,000)
- Mobil (Rp 15,000)
- Express Motor (Rp 20,000)
- Express Mobil (Rp 30,000)

### Payment Methods
The system includes 6 payment methods:
- Debit Card
- Bank Transfer
- E-Wallet
- Cash
- Indomaret (in database but hidden from UI)
- Alfamart (in database but hidden from UI)

## Troubleshooting

### Database Import Issues
If you encounter errors during database import:
1. Drop the existing database: `DROP DATABASE mysticakedb;`
2. Create a fresh database: `CREATE DATABASE mysticakedb;`
3. Re-import the SQL file

### Migration Issues
Jika ada error saat menjalankan migration:
```bash
# Reset migration jika perlu
php artisan migrate:fresh

# Atau import ulang SQL dan jalankan migration
```

### Permission Issues
If you encounter permission errors:
```bash
chmod -R 775 storage bootstrap/cache
```

### Cache Issues
If you see unexpected behavior, clear the cache:
```bash
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear
```

## Quick Setup (TLDR)
Bagi yang sudah familiar, cukup jalankan:
```bash
git pull origin main
composer install
php artisan migrate
php artisan serve
```

## Notes
- Make sure your database is properly configured before running the application
- Selalu jalankan `php artisan migrate` setelah pull kode terbaru
- The application uses Bootstrap Icons for UI elements
- Foto review tersimpan di `public/images/reviews/`
