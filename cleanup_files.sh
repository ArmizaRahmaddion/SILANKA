#!/bin/bash
# ============================================
# SCRIPT PEMBERSIHAN FILE APLIKASI SILANKA  
# Hapus file-file yang tidak terpakai
# ============================================

echo "🧹 MEMULAI PEMBERSIHAN FILE TIDAK TERPAKAI..."

# Backup file penting dulu
echo "📦 Membuat backup..."
mkdir -p backup_files
cp -r app/Http/Controllers/KopSuratController.php backup_files/ 2>/dev/null
cp -r app/Http/Controllers/TemplateSuratController.php backup_files/ 2>/dev/null
cp -r app/Models/KopSurat.php backup_files/ 2>/dev/null
cp -r app/Models/TemplateSurat.php backup_files/ 2>/dev/null

echo "🗑️ Menghapus Controllers tidak terpakai..."
# Hapus controllers yang tidak terpakai
rm -f app/Http/Controllers/KopSuratController.php
rm -f app/Http/Controllers/TemplateSuratController.php

echo "🗑️ Menghapus Models tidak terpakai..." 
# Hapus models yang tidak terpakai
rm -f app/Models/KopSurat.php
rm -f app/Models/TemplateSurat.php

echo "🗑️ Membersihkan file public yang tidak terpakai..."
# Hapus file HTML statis yang tidak digunakan
rm -f public/landing-page/portfolio-details.html 2>/dev/null

echo "🗑️ Membersihkan views yang tidak terpakai..."
# Hapus views untuk KopSurat dan TemplateSurat jika ada
rm -rf resources/views/layouts/admin/pengaturan/kop-surat/ 2>/dev/null
rm -rf resources/views/layouts/admin/pengaturan/template-surat/ 2>/dev/null

echo "🔧 Membersihkan routes yang tidak terpakai..."
# Info: Manual check routes/web.php untuk menghapus route kop-surat dan template-surat

echo "📝 Files yang dihapus:"
echo "   ✅ app/Http/Controllers/KopSuratController.php"
echo "   ✅ app/Http/Controllers/TemplateSuratController.php" 
echo "   ✅ app/Models/KopSurat.php"
echo "   ✅ app/Models/TemplateSurat.php"
echo "   ✅ public/landing-page/portfolio-details.html"
echo "   ✅ Views untuk KopSurat dan TemplateSurat"

echo ""
echo "⚠️  LANGKAH MANUAL YANG DIPERLUKAN:"
echo "   1. Jalankan: php artisan route:clear"
echo "   2. Jalankan: php artisan config:clear"  
echo "   3. Jalankan: php artisan view:clear"
echo "   4. Periksa routes/web.php untuk route yang tidak terpakai"
echo "   5. Jalankan script SQL cleanup_unused_files.sql untuk database"

echo ""
echo "✅ PEMBERSIHAN FILE SELESAI!"
echo "📦 Backup file tersimpan di folder: backup_files/"