# LAPORAN ANALISIS FILE TIDAK TERPAKAI
# SISTEM SILANKA - LARAVEL 12
# Tanggal: 2 Oktober 2025

## RINGKASAN ANALISIS
- **Total Routes Aktif:** 119 routes
- **Total Tabel Database:** 67 tabel  
- **Tabel Aktif/Terpakai:** 24 tabel
- **Tabel Tidak Terpakai:** 43 tabel
- **Models Tidak Terpakai:** 2 models
- **Controllers Tidak Terpakai:** 4 controllers

## FILE TIDAK TERPAKAI YANG DITEMUKAN

### 1. DATABASE TABLES (43 tabel)
**Tabel Kosong/Tanpa Struktur:**
- kop_surat, template_surat, test_generate_surats
- personal_access_tokens, password_resets

**Tabel Sistem Lama (kemungkinan dari aplikasi lain):**
- tbbeli, tbcart, tbjual, tbkategori, tbkontak, tbmutasi
- tborders, tbpelanggan, tbpemasok, tbpesanan, tbproduk
- tbrestok, tbrole, tbsatuan, tbstok, tbchechkout1
- tbcheckout, tbkeranjang, tbpesanan_details, tbpesanans
- tbroles, tbsliders, tbbarbermen, tbbooking, tbjadwal
- tbkategoris, tbtokos, announcements, blog_categories
- blog_comments, blog_likes, blog_tags, blogs, galleries
- news, structurals, masyarakats, pegawais, verifikasi_users

### 2. CONTROLLERS (4 files)  
**Tidak Terpakai:**
- KopSuratController.php (tabel kop_surat kosong)
- TemplateSuratController.php (tabel template_surat kosong)
- Auth/ForgotPasswordController.php (password reset disabled) 
- Auth/ResetPasswordController.php (password reset disabled)

**Penggunaan Minimal:**
- SuratKeteranganAhliWarisController.php (hanya 1 method)
- MainController.php (fungsi terbatas)

### 3. MODELS (2 files)
**Tidak Terpakai:**
- KopSurat.php (tidak ada tabel yang sesuai)
- TemplateSurat.php (tidak ada tabel yang sesuai) 

### 4. VIEWS/ASSETS
**Berpotensi Tidak Terpakai:**
- Views untuk KopSurat dan TemplateSurat
- Password reset views (fitur disabled)
- public/landing-page/portfolio-details.html
- Beberapa assets di public/ yang tidak di-reference

## FILE YANG MASIH AKTIF/TERPAKAI

### Controllers Aktif (15 controllers utama):
- SuratTerbitController.php ✅
- PermintaanSuratController.php ✅  
- VerifikasiPenggunaController.php ✅
- VerifikasiSuratFinalController.php ✅
- RiwayatSuratController.php ✅
- RiwayatPengaduanController.php ✅
- PengaduanController.php ✅
- PenggunaController.php ✅
- PerangkatNagariController.php ✅
- KontenController.php ✅
- KategoriKotenController.php ✅
- BeritaController.php ✅
- CekSuratController.php ✅
- SuratController.php ✅
- DeviceFonnteController.php ✅

### Models Aktif (17 models utama):
- User.php ✅
- PermintaanSurat.php ✅
- StatusPermintaanSurat.php ✅
- SuratTerbit.php ✅
- VerifikasiPengguna.php ✅
- VerifikasiSuratFinal.php ✅
- JenisSurat.php ✅
- Pengaduan.php ✅
- KategoriPengaduan.php ✅
- PerangkatNagari.php ✅
- SuratKeteranganDomisili.php ✅
- SuratKeteranganMeninggalDunia.php ✅
- SuratKeteranganTidakMampu.php ✅
- SuratKeteranganUsaha.php ✅
- SKTMKeluarga.php ✅
- Konten.php ✅
- KategoriKoten.php ✅

### Tabel Database Aktif (24 tabel):
- users, permissions, roles, model_has_* ✅
- verifikasi_pengguna ✅
- kategori_pengaduan, pengaduan ✅
- perangkat_nagari ✅
- jenis_surat, permintaan_surat ✅
- surat_keterangan_* (4 tabel) ✅
- sktm_keluarga ✅
- surat_terbit, final_surat ✅
- arsip_surat, kategori_arsip ✅
- kategori_kotens, kontens ✅
- status_permintaan_surats ✅
- cache, sessions, jobs, migrations ✅

## DAMPAK PEMBERSIHAN
**Ukuran yang Akan Dihemat:**
- Database: ~43 tabel kosong
- Files: ~6 files (controllers + models)
- Assets: Beberapa files di public/

**Risiko:**
- Rendah untuk tabel kosong dan tb* tables
- Sedang untuk KopSurat/TemplateSurat (mungkin akan dikembangkan nanti)
- Tinggi untuk files yang masih memiliki reference di code

## REKOMENDASI
1. **AMAN DIHAPUS:** Tabel tb*, blog*, files kosong
2. **CEK DULU:** KopSurat, TemplateSurat files  
3. **BIARKAN:** Semua files surat utama, controllers aktif

## LANGKAH PEMBERSIHAN
1. Backup database dan files
2. Jalankan cleanup_unused_files.sql
3. Jalankan cleanup_files.sh
4. Clear cache Laravel
5. Test semua functionality

---
**Catatan:** Analisis dilakukan pada tanggal 2 Oktober 2025 berdasarkan:
- Routes analysis (119 routes)
- Database schema analysis (67 tabel)  
- File usage analysis
- Code reference checking