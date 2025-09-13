# Dokumentasi KontenSeeder

## Deskripsi

KontenSeeder adalah seeder yang berisi data sample konten untuk sistem e-surat nagari. Seeder ini dibuat untuk memudahkan testing dan demonstrasi fitur CRUD manajemen konten.

## Konten yang Dibuat

### 1. **Berita Umum**

-   **Peluncuran Sistem E-Surat Digital Nagari**

    -   Status: Published
    -   Author: Tim Redaksi Nagari
    -   Konten: Pengumuman resmi peluncuran sistem e-surat dengan fitur dan keunggulannya

-   **Rencana Pembangunan Balai Nagari Baru Tahun 2026**
    -   Status: Draft
    -   Author: Bagian Perencanaan
    -   Konten: Rencana pembangunan fasilitas pelayanan baru (masih draft)

### 2. **Pengumuman**

-   **Pengumuman Jadwal Pelayanan Administrasi Bulan Ramadan**
    -   Status: Published
    -   Author: Bagian Pelayanan
    -   Konten: Penyesuaian jadwal pelayanan dengan tabel jam operasional lengkap

### 3. **Kegiatan Nagari**

-   **Gotong Royong Pembangunan Jalan Lingkungan RT 05**
    -   Status: Published
    -   Author: Humas Nagari
    -   Konten: Laporan kegiatan gotong royong dengan detail anggaran dan kontribusi

### 4. **Pelayanan Publik**

-   **Panduan Lengkap Mengurus Surat Keterangan Domisili Online**
    -   Status: Published
    -   Author: Tim Pelayanan Digital
    -   Konten: Tutorial lengkap proses pengajuan surat online dengan syarat dan langkah-langkah

### 5. **Artikel**

-   **Manfaat Digitalisasi Pelayanan Publik di Era Modern**
    -   Status: Published
    -   Author: Dr. Ahmad Syafii, M.Si
    -   Konten: Artikel mendalam tentang manfaat digitalisasi dengan analisis komprehensif

### 6. **Tutorial**

-   **Tutorial: Cara Reset Password Akun E-Surat**
    -   Status: Published
    -   Author: Tim IT Support
    -   Konten: Panduan teknis reset password dengan troubleshooting dan tips keamanan

## Fitur Rich Content

Setiap konten menggunakan rich text HTML dengan fitur:

-   ✅ **Headers** (H1-H6) untuk struktur konten
-   ✅ **Lists** (ordered & unordered) untuk informasi terstruktur
-   ✅ **Tables** untuk data tabular (jadwal, anggaran)
-   ✅ **Blockquotes** untuk kutipan penting
-   ✅ **Code blocks** untuk contoh kode/command
-   ✅ **Colored boxes** untuk highlight informasi penting
-   ✅ **Strong/Bold text** untuk penekanan
-   ✅ **Emoji** untuk visual appeal

## Cara Menjalankan

```bash
# Jalankan seeder kategori terlebih dahulu
php artisan db:seed --class=KategoriKotenSeeder

# Kemudian jalankan seeder konten
php artisan db:seed --class=KontenSeeder

# Atau jalankan semua seeder sekaligus
php artisan db:seed
```

## Validasi Data

Seeder akan:

-   ✅ Mengecek keberadaan kategori sebelum membuat konten
-   ✅ Mencegah duplikasi berdasarkan slug
-   ✅ Memberikan feedback jumlah konten yang berhasil ditambahkan
-   ✅ Menampilkan peringatan jika kategori belum ada

## Testing Data

Setelah seeder dijalankan, Anda akan memiliki:

-   **7 konten sample** dengan berbagai kategori
-   **6 konten published** siap untuk ditampilkan
-   **1 konten draft** untuk testing fitur draft
-   **Rich content** untuk testing Quill editor
-   **Beragam author** untuk testing metadata
-   **Konten realistis** sesuai konteks e-surat nagari

## Integrasi dengan Sistem

Data seeder ini dirancang untuk:

-   🎯 **Testing CRUD operations** - Create, Read, Update, Delete
-   🎯 **Testing Quill editor** - Rich text rendering dan editing
-   🎯 **Testing kategori relations** - Many-to-one relationship
-   🎯 **Testing status management** - Published vs Draft
-   🎯 **Testing search & filter** - Berdasarkan kategori, status, author
-   🎯 **Demo purposes** - Showcase fitur lengkap sistem
