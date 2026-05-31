# POS Retail Management System

Aplikasi POS / Kasir berbasis web dan PWA untuk membantu operasional toko agar lebih cepat, rapi, dan efisien.

## Fitur Utama

- ✅ Terminal POS dengan scan barcode
- ✅ Manajemen Produk & Stok Multi-Cabang
- ✅ Member & Loyalty Program
- ✅ Promo & Voucher Fleksibel
- ✅ Shift Management & Closing Kasir
- ✅ Laporan Penjualan, Stok & Laba Rugi
- ✅ PWA Support untuk mobile
- ✅ Multi-User & Multi-Cabang

## Teknologi

- **Backend**: PHP CodeIgniter 4
- **Database**: MySQL / MariaDB
- **Frontend**: Bootstrap 5, JavaScript, AJAX
- **Payment Gateway**: Midtrans (QRIS)
- **PWA**: Service Worker & Manifest

## Role & Akses

1. **Super Admin** - Kelola semua cabang, user, produk, promo, laporan
2. **Admin Cabang** - Kelola data cabang, stok, transaksi, kasir
3. **Kasir** - Terminal POS, riwayat transaksi, presensi, shift

## Roadmap (10 Tahap)

### Tahap 1: Fondasi Sistem ✅ (CURRENT)
- Setup CodeIgniter 4
- Database schema
- Login & Role Management
- Layout Dashboard
- Manajemen Cabang & User
- Pengaturan Toko

### Tahap 2-10
Lihat dokumentasi lengkap di docs/ROADMAP.md

## Instalasi

```bash
# Clone repository
git clone https://github.com/id0s/pos-retail-system.git
cd pos-retail-system

# Setup environment
cp .env.example .env

# Install dependencies
composer install

# Generate encryption key
php spark key:generate

# Migrate database
php spark migrate

# Seed data (optional)
php spark db:seed DatabaseSeeder

# Jalankan server
php spark serve
```

## Akses Aplikasi

Buka: `http://localhost:8080`

### Login Default

**Super Admin**
- Username: `admin`
- Password: `admin123`

**Admin Cabang**
- Username: `admin_cabang`
- Password: `admin123`

**Kasir**
- Username: `kasir`
- Password: `kasir123`

## Struktur Project

```
pos-retail-system/
├── app/
│   ├── Config/
│   ├── Controllers/
│   ├── Models/
│   ├── Views/
│   ├── Database/
│   └── Filters/
├── public/
│   ├── css/
│   ├── js/
│   ├── images/
│   └── manifest.json
├── docs/
├── .env.example
├── composer.json
└── README.md
```

## Dokumentasi

- [Roadmap Pengembangan](docs/ROADMAP.md)
- [Database Schema](docs/DATABASE_SCHEMA.md)
- [API Dokumentasi](docs/API.md) - Coming Soon
- [User Manual](docs/USER_MANUAL.md) - Coming Soon

## License

MIT License - Gratis untuk digunakan dan dikembangkan

## Support

Untuk bantuan atau pertanyaan, silakan buat issue di GitHub.
