-- ============================================
-- SCRIPT PEMBERSIHAN DATABASE SILANKA
-- Hapus tabel-tabel yang tidak terpakai
-- ============================================

-- Backup dulu sebelum menjalankan script ini!
-- mysqldump -u username -p db_e_surat_test > backup_before_cleanup.sql

-- 1. Drop tabel sistem lama yang tidak terpakai
DROP TABLE IF EXISTS `tbbeli`;
DROP TABLE IF EXISTS `tbcart`; 
DROP TABLE IF EXISTS `tbjual`;
DROP TABLE IF EXISTS `tbkategori`;
DROP TABLE IF EXISTS `tbkontak`;
DROP TABLE IF EXISTS `tbmutasi`;
DROP TABLE IF EXISTS `tborders`;
DROP TABLE IF EXISTS `tbpelanggan`;
DROP TABLE IF EXISTS `tbpemasok`;
DROP TABLE IF EXISTS `tbpesanan`;
DROP TABLE IF EXISTS `tbproduk`;
DROP TABLE IF EXISTS `tbrestok`;
DROP TABLE IF EXISTS `tbrole`;
DROP TABLE IF EXISTS `tbsatuan`;
DROP TABLE IF EXISTS `tbstok`;
DROP TABLE IF EXISTS `tbchechkout1`;
DROP TABLE IF EXISTS `tbcheckout`;
DROP TABLE IF EXISTS `tbkeranjang`;
DROP TABLE IF EXISTS `tbpesanan_details`;
DROP TABLE IF EXISTS `tbpesanans`;
DROP TABLE IF EXISTS `tbroles`;
DROP TABLE IF EXISTS `tbsliders`;
DROP TABLE IF EXISTS `tbbarbermen`;
DROP TABLE IF EXISTS `tbbooking`;
DROP TABLE IF EXISTS `tbjadwal`;
DROP TABLE IF EXISTS `tbkategoris`;
DROP TABLE IF EXISTS `tbtokos`;

-- 2. Drop tabel blog system yang tidak digunakan
DROP TABLE IF EXISTS `announcements`;
DROP TABLE IF EXISTS `blog_categories`;
DROP TABLE IF EXISTS `blog_comments`;
DROP TABLE IF EXISTS `blog_likes`;
DROP TABLE IF EXISTS `blog_tags`;
DROP TABLE IF EXISTS `blogs`;
DROP TABLE IF EXISTS `galleries`;
DROP TABLE IF EXISTS `news`;
DROP TABLE IF EXISTS `structurals`;
DROP TABLE IF EXISTS `masyarakats`;
DROP TABLE IF EXISTS `pegawais`;
DROP TABLE IF EXISTS `verifikasi_users`;

-- 3. Drop tabel kosong yang tidak memiliki struktur
DROP TABLE IF EXISTS `kop_surat`;
DROP TABLE IF EXISTS `template_surat`;  
DROP TABLE IF EXISTS `test_generate_surats`;
DROP TABLE IF EXISTS `personal_access_tokens`;
DROP TABLE IF EXISTS `password_resets`;

-- 4. Informasi tabel yang masih AKTIF dan JANGAN DIHAPUS:
/*
TABEL AKTIF - JANGAN DIHAPUS:
- users
- permissions, roles, model_has_permissions, model_has_roles, role_has_permissions
- verifikasi_pengguna  
- kategori_pengaduan, pengaduan
- perangkat_nagari
- jenis_surat, permintaan_surat
- surat_keterangan_meninggal_dunia
- surat_keterangan_domisili  
- surat_keterangan_usaha
- surat_keterangan_tidak_mampu
- sktm_keluarga
- surat_terbit
- final_surat
- arsip_surat, kategori_arsip
- kategori_kotens, kontens
- status_permintaan_surats
- cache, cache_locks, sessions
- jobs, job_batches, failed_jobs
- password_reset_tokens
- migrations
*/

SELECT 'Pembersihan database selesai!' as status;