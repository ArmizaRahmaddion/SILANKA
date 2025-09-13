<?php

namespace Database\Seeders;

use App\Models\Konten;
use App\Models\KategoriKoten;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class KontenSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Pastikan kategori sudah ada
        $kategoris = KategoriKoten::all();

        if ($kategoris->isEmpty()) {
            $this->command->warn('Kategori konten belum ada. Jalankan KategoriKotenSeeder terlebih dahulu.');
            return;
        }

        $kontens = [
            // Berita Umum
            [
                'kategori_koten_id' => $kategoris->where('slug', 'berita-umum')->first()->id ?? $kategoris->first()->id,
                'title' => 'Peluncuran Sistem E-Surat Digital Nagari',
                'body' => '<h2>Sistem E-Surat Digital untuk Kemudahan Masyarakat</h2>
                    <p>Dalam rangka meningkatkan pelayanan publik dan mempermudah akses masyarakat terhadap layanan administrasi, Pemerintah Nagari dengan bangga mengumumkan peluncuran <strong>Sistem E-Surat Digital</strong>.</p>
                    
                    <h3>Keunggulan Sistem E-Surat:</h3>
                    <ul>
                        <li>Proses pengajuan surat menjadi lebih cepat dan efisien</li>
                        <li>Dapat diakses 24/7 melalui website resmi</li>
                        <li>Tracking status pengajuan secara real-time</li>
                        <li>Mengurangi penggunaan kertas (paperless)</li>
                        <li>Terintegrasi dengan sistem verifikasi digital</li>
                    </ul>
                    
                    <blockquote>
                        "Dengan adanya sistem e-surat ini, kami berharap dapat memberikan pelayanan yang lebih baik kepada masyarakat dan mengurangi waktu tunggu dalam proses administrasi." - Wali Nagari
                    </blockquote>
                    
                    <p>Sistem ini telah diuji coba selama 3 bulan dan mendapat respon positif dari masyarakat. Tingkat kepuasan masyarakat mencapai 95% dengan rata-rata waktu penyelesaian surat berkurang hingga 70%.</p>',
                'slug' => 'peluncuran-sistem-e-surat-digital-nagari',
                'author' => 'Tim Redaksi Nagari',
                'status' => 'published',
            ],

            // Pengumuman
            [
                'kategori_koten_id' => $kategoris->where('slug', 'pengumuman')->first()->id ?? $kategoris->first()->id,
                'title' => 'Pengumuman Jadwal Pelayanan Administrasi Bulan Ramadan',
                'body' => '<h2>Penyesuaian Jam Pelayanan Selama Bulan Ramadan</h2>
                    <p>Dalam rangka menyambut bulan suci Ramadan 1446 H, Kantor Nagari mengumumkan penyesuaian jadwal pelayanan administrasi sebagai berikut:</p>
                    
                    <h3>📅 Jadwal Pelayanan:</h3>
                    <table style="width: 100%; border-collapse: collapse; margin: 20px 0;">
                        <thead>
                            <tr style="background-color: #f8f9fa;">
                                <th style="border: 1px solid #ddd; padding: 12px; text-align: left;">Hari</th>
                                <th style="border: 1px solid #ddd; padding: 12px; text-align: left;">Jam Pelayanan</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td style="border: 1px solid #ddd; padding: 8px;">Senin - Kamis</td>
                                <td style="border: 1px solid #ddd; padding: 8px;">08:00 - 14:00 WIB</td>
                            </tr>
                            <tr>
                                <td style="border: 1px solid #ddd; padding: 8px;">Jumat</td>
                                <td style="border: 1px solid #ddd; padding: 8px;">08:00 - 11:00 WIB</td>
                            </tr>
                            <tr>
                                <td style="border: 1px solid #ddd; padding: 8px;">Sabtu</td>
                                <td style="border: 1px solid #ddd; padding: 8px;">TUTUP</td>
                            </tr>
                        </tbody>
                    </table>
                    
                    <div style="background-color: #d1ecf1; border: 1px solid #bee5eb; padding: 15px; border-radius: 5px; margin: 20px 0;">
                        <strong>📢 Catatan Penting:</strong>
                        <ul style="margin-bottom: 0;">
                            <li>Pelayanan online melalui sistem e-surat tetap tersedia 24/7</li>
                            <li>Untuk keperluan mendesak, silakan hubungi hotline: 0856-xxxx-xxxx</li>
                            <li>Jadwal ini berlaku mulai 1 Ramadan hingga Idul Fitri</li>
                        </ul>
                    </div>
                    
                    <p>Kami mohon maaf atas ketidaknyamanan yang mungkin terjadi dan berharap agar masyarakat dapat memahami penyesuaian ini.</p>',
                'slug' => 'pengumuman-jadwal-pelayanan-administrasi-bulan-ramadan',
                'author' => 'Bagian Pelayanan',
                'status' => 'published',
            ],

            // Kegiatan Nagari
            [
                'kategori_koten_id' => $kategoris->where('slug', 'kegiatan-nagari')->first()->id ?? $kategoris->first()->id,
                'title' => 'Gotong Royong Pembangunan Jalan Lingkungan RT 05',
                'body' => '<h2>Partisipasi Masyarakat dalam Pembangunan Infrastruktur</h2>
                    <p>Pada hari Minggu, 10 September 2025, masyarakat RT 05 Nagari telah melaksanakan kegiatan gotong royong pembangunan jalan lingkungan dengan penuh semangat dan kebersamaan.</p>
                    
                    <h3>🏗️ Detail Kegiatan:</h3>
                    <ul>
                        <li><strong>Waktu:</strong> Minggu, 10 September 2025, 07:00 - 12:00 WIB</li>
                        <li><strong>Lokasi:</strong> Jalan Lingkungan RT 05, Kampung Tengah</li>
                        <li><strong>Peserta:</strong> 45 kepala keluarga + perangkat nagari</li>
                        <li><strong>Panjang jalan:</strong> 200 meter</li>
                        <li><strong>Lebar jalan:</strong> 3 meter</li>
                    </ul>
                    
                    <h3>📋 Jenis Pekerjaan:</h3>
                    <ol>
                        <li>Pembersihan lahan dan perataan tanah</li>
                        <li>Pemasangan batu pondasi</li>
                        <li>Pengecoran dengan material semen dan pasir</li>
                        <li>Pembuatan saluran drainase</li>
                    </ol>
                    
                    <blockquote>
                        "Alhamdulillah, dengan gotong royong ini, akses jalan menuju area persawahan dan perkebunan warga menjadi lebih mudah, terutama saat musim hujan." - Ketua RT 05
                    </blockquote>
                    
                    <h3>💰 Anggaran dan Kontribusi:</h3>
                    <p>Total anggaran pembangunan sebesar <strong>Rp 15.000.000</strong> yang bersumber dari:</p>
                    <ul>
                        <li>Dana swadaya masyarakat: Rp 8.000.000 (53%)</li>
                        <li>Bantuan Pemerintah Nagari: Rp 5.000.000 (33%)</li>
                        <li>Bantuan swasta: Rp 2.000.000 (14%)</li>
                    </ul>
                    
                    <p>Kegiatan ini merupakan bukti nyata bahwa dengan semangat gotong royong dan partisipasi aktif masyarakat, pembangunan infrastruktur dapat terealisasi dengan baik dan bermanfaat bagi kepentingan bersama.</p>',
                'slug' => 'gotong-royong-pembangunan-jalan-lingkungan-rt-05',
                'author' => 'Humas Nagari',
                'status' => 'published',
            ],

            // Pelayanan Publik
            [
                'kategori_koten_id' => $kategoris->where('slug', 'pelayanan-publik')->first()->id ?? $kategoris->first()->id,
                'title' => 'Panduan Lengkap Mengurus Surat Keterangan Domisili Online',
                'body' => '<h2>Cara Mudah Mengurus Surat Keterangan Domisili secara Online</h2>
                    <p>Surat Keterangan Domisili merupakan salah satu dokumen penting yang sering dibutuhkan untuk berbagai keperluan administrasi. Kini, dengan sistem e-surat, Anda dapat mengurus surat ini dengan mudah dari rumah.</p>
                    
                    <h3>📋 Syarat dan Ketentuan:</h3>
                    <ul>
                        <li>Fotocopy KTP yang masih berlaku</li>
                        <li>Fotocopy Kartu Keluarga (KK)</li>
                        <li>Surat pengantar dari RT/RW (jika diperlukan)</li>
                        <li>Pas foto 3x4 (1 lembar)</li>
                        <li>Surat keterangan dari instansi/lembaga yang membutuhkan (jika ada)</li>
                    </ul>
                    
                    <h3>🔄 Langkah-langkah Pengajuan Online:</h3>
                    <ol>
                        <li>
                            <strong>Akses Website</strong><br>
                            Kunjungi website resmi e-surat nagari
                        </li>
                        <li>
                            <strong>Registrasi/Login</strong><br>
                            Daftar akun baru atau login jika sudah memiliki akun
                        </li>
                        <li>
                            <strong>Pilih Jenis Surat</strong><br>
                            Pilih "Surat Keterangan Domisili" dari menu layanan
                        </li>
                        <li>
                            <strong>Isi Formulir</strong><br>
                            Lengkapi semua data yang diperlukan dengan benar
                        </li>
                        <li>
                            <strong>Upload Dokumen</strong><br>
                            Upload scan dokumen syarat dalam format PDF/JPG (max 2MB)
                        </li>
                        <li>
                            <strong>Review dan Submit</strong><br>
                            Periksa kembali data Anda sebelum mengirim pengajuan
                        </li>
                    </ol>
                    
                    <div style="background-color: #d4edda; border: 1px solid #c3e6cb; padding: 15px; border-radius: 5px; margin: 20px 0;">
                        <h4 style="color: #155724; margin-top: 0;">⏰ Estimasi Waktu Penyelesaian:</h4>
                        <ul style="margin-bottom: 0; color: #155724;">
                            <li><strong>Pengajuan online:</strong> 1-2 hari kerja</li>
                            <li><strong>Pengajuan offline:</strong> 3-5 hari kerja</li>
                            <li><strong>Penjemputan dokumen:</strong> Tersedia</li>
                        </ul>
                    </div>
                    
                    <h3>📱 Cara Tracking Status:</h3>
                    <p>Setelah pengajuan berhasil dikirim, Anda akan mendapat nomor tracking. Gunakan nomor ini untuk mengecek status pengajuan melalui:</p>
                    <ul>
                        <li>Website e-surat (menu "Cek Status")</li>
                        <li>WhatsApp Bot: 0856-xxxx-xxxx</li>
                        <li>SMS ke nomor: 0856-xxxx-xxxx</li>
                    </ul>
                    
                    <h3>💡 Tips Penting:</h3>
                    <ul>
                        <li>Pastikan foto dokumen clear dan tidak blur</li>
                        <li>Isi data sesuai dengan dokumen asli</li>
                        <li>Simpan nomor tracking untuk memudahkan pengecekan</li>
                        <li>Jika ada kendala, hubungi customer service kami</li>
                    </ul>
                    
                    <p><strong>Customer Service:</strong> 0856-xxxx-xxxx (WhatsApp) | pelayanan@nagari.go.id</p>',
                'slug' => 'panduan-lengkap-mengurus-surat-keterangan-domisili-online',
                'author' => 'Tim Pelayanan Digital',
                'status' => 'published',
            ],

            // Artikel
            [
                'kategori_koten_id' => $kategoris->where('slug', 'artikel')->first()->id ?? $kategoris->first()->id,
                'title' => 'Manfaat Digitalisasi Pelayanan Publik di Era Modern',
                'body' => '<h2>Transformasi Digital dalam Pelayanan Masyarakat</h2>
                    <p>Era digital telah mengubah cara kita berinteraksi dan mengakses berbagai layanan, termasuk layanan publik. Digitalisasi pelayanan publik bukan lagi sekadar tren, melainkan kebutuhan mendesak untuk meningkatkan kualitas hidup masyarakat.</p>
                    
                    <h3>🌟 Mengapa Digitalisasi Penting?</h3>
                    <p>Pelayanan publik tradisional seringkali menghadapi berbagai tantangan seperti birokrasi yang panjang, waktu tunggu yang lama, dan keterbatasan akses geografis. Digitalisasi hadir sebagai solusi untuk mengatasi permasalahan tersebut.</p>
                    
                    <h3>📈 Manfaat Utama Digitalisasi:</h3>
                    
                    <h4>1. Efisiensi Waktu dan Biaya</h4>
                    <ul>
                        <li>Proses yang lebih cepat dengan sistem otomatis</li>
                        <li>Mengurangi biaya operasional dan transportasi</li>
                        <li>Eliminasi antrian panjang</li>
                    </ul>
                    
                    <h4>2. Aksesibilitas 24/7</h4>
                    <ul>
                        <li>Layanan tersedia kapan saja dan di mana saja</li>
                        <li>Tidak terbatas jam operasional kantor</li>
                        <li>Akses mudah melalui smartphone atau komputer</li>
                    </ul>
                    
                    <h4>3. Transparansi dan Akuntabilitas</h4>
                    <ul>
                        <li>Tracking real-time status pengajuan</li>
                        <li>Proses yang jelas dan terukur</li>
                        <li>Mengurangi praktik KKN</li>
                    </ul>
                    
                    <h4>4. Ramah Lingkungan</h4>
                    <ul>
                        <li>Pengurangan penggunaan kertas (paperless)</li>
                        <li>Mengurangi emisi karbon dari transportasi</li>
                        <li>Penyimpanan digital yang lebih efisien</li>
                    </ul>
                    
                    <blockquote>
                        "Digitalisasi bukan hanya tentang teknologi, tetapi tentang bagaimana kita dapat memberikan pelayanan terbaik kepada masyarakat dengan cara yang lebih efektif dan efisien."
                    </blockquote>
                    
                    <h3>🎯 Implementasi di Tingkat Nagari</h3>
                    <p>Sebagai unit pemerintahan terkecil, nagari memiliki peran strategis dalam implementasi digitalisasi pelayanan publik. Beberapa langkah yang dapat ditempuh:</p>
                    
                    <ol>
                        <li><strong>Pembangunan Infrastruktur Digital</strong><br>
                            Investasi pada teknologi informasi dan komunikasi yang memadai</li>
                        <li><strong>Pelatihan SDM</strong><br>
                            Peningkatan kapasitas aparatur dalam menggunakan teknologi digital</li>
                        <li><strong>Sosialisasi kepada Masyarakat</strong><br>
                            Edukasi masyarakat tentang cara menggunakan layanan digital</li>
                        <li><strong>Evaluasi dan Perbaikan Berkelanjutan</strong><br>
                            Monitoring dan evaluasi sistem secara berkala</li>
                    </ol>
                    
                    <h3>🚀 Masa Depan Pelayanan Digital</h3>
                    <p>Ke depan, digitalisasi pelayanan publik akan semakin berkembang dengan integrasi teknologi terbaru seperti:</p>
                    <ul>
                        <li>Artificial Intelligence (AI) untuk otomasi proses</li>
                        <li>Blockchain untuk keamanan data</li>
                        <li>Internet of Things (IoT) untuk pelayanan yang lebih responsif</li>
                        <li>Big Data Analytics untuk pengambilan keputusan yang lebih baik</li>
                    </ul>
                    
                    <p>Dengan terus berinovasi dan beradaptasi dengan teknologi, kita dapat menciptakan pelayanan publik yang lebih baik, lebih cepat, dan lebih mudah diakses oleh seluruh masyarakat.</p>',
                'slug' => 'manfaat-digitalisasi-pelayanan-publik-di-era-modern',
                'author' => 'Dr. Ahmad Syafii, M.Si',
                'status' => 'published',
            ],

            // Tutorial
            [
                'kategori_koten_id' => $kategoris->where('slug', 'tutorial')->first()->id ?? $kategoris->first()->id,
                'title' => 'Tutorial: Cara Reset Password Akun E-Surat',
                'body' => '<h2>Panduan Lengkap Reset Password Akun E-Surat</h2>
                    <p>Lupa password akun e-surat Anda? Jangan khawatir! Ikuti tutorial berikut ini untuk mereset password dengan mudah dan aman.</p>
                    
                    <div style="background-color: #fff3cd; border: 1px solid #ffeaa7; padding: 15px; border-radius: 5px; margin: 20px 0;">
                        <strong>⚠️ Catatan Penting:</strong><br>
                        Pastikan Anda memiliki akses ke email yang terdaftar di akun e-surat Anda.
                    </div>
                    
                    <h3>🔄 Metode 1: Reset Password via Website</h3>
                    
                    <h4>Langkah 1: Akses Halaman Login</h4>
                    <ol>
                        <li>Buka browser dan kunjungi website e-surat nagari</li>
                        <li>Klik tombol <strong>"Login"</strong> di pojok kanan atas</li>
                        <li>Pada halaman login, cari dan klik link <strong>"Lupa Password?"</strong></li>
                    </ol>
                    
                    <h4>Langkah 2: Masukkan Email</h4>
                    <ol>
                        <li>Masukkan alamat email yang terdaftar di akun Anda</li>
                        <li>Klik tombol <strong>"Kirim Link Reset"</strong></li>
                        <li>Sistem akan mengirimkan email berisi link reset password</li>
                    </ol>
                    
                    <h4>Langkah 3: Cek Email</h4>
                    <ol>
                        <li>Buka email Anda (cek juga folder Spam/Junk)</li>
                        <li>Cari email dari "noreply@esurat-nagari.go.id"</li>
                        <li>Klik link reset password yang ada di email</li>
                    </ol>
                    
                    <h4>Langkah 4: Buat Password Baru</h4>
                    <ol>
                        <li>Anda akan diarahkan ke halaman reset password</li>
                        <li>Masukkan password baru yang kuat (minimal 8 karakter)</li>
                        <li>Konfirmasi password baru Anda</li>
                        <li>Klik <strong>"Update Password"</strong></li>
                    </ol>
                    
                    <h3>📱 Metode 2: Reset Password via WhatsApp</h3>
                    
                    <p>Jika Anda kesulitan dengan metode email, bisa menggunakan layanan WhatsApp:</p>
                    <ol>
                        <li>Kirim pesan WhatsApp ke <strong>0856-xxxx-xxxx</strong></li>
                        <li>Ketik: <code>RESET [NIK] [EMAIL]</code></li>
                        <li>Contoh: <code>RESET 1234567890123456 user@email.com</code></li>
                        <li>Admin akan membantu proses reset password Anda</li>
                    </ol>
                    
                    <h3>🔐 Tips Membuat Password yang Kuat</h3>
                    
                    <div style="background-color: #d1ecf1; border: 1px solid #bee5eb; padding: 15px; border-radius: 5px;">
                        <h4>Password yang baik harus memiliki:</h4>
                        <ul>
                            <li>✅ Minimal 8 karakter</li>
                            <li>✅ Kombinasi huruf besar dan kecil</li>
                            <li>✅ Mengandung angka</li>
                            <li>✅ Mengandung simbol khusus (!@#$%)</li>
                            <li>❌ Jangan gunakan data pribadi (nama, tanggal lahir)</li>
                            <li>❌ Jangan gunakan kata yang mudah ditebak</li>
                        </ul>
                    </div>
                    
                    <h4>Contoh Password Kuat:</h4>
                    <ul>
                        <li><code>Nagari2025!</code></li>
                        <li><code>MyPass#123</code></li>
                        <li><code>Esurat@2025</code></li>
                    </ul>
                    
                    <h3>🛡️ Keamanan Akun</h3>
                    
                    <p>Untuk menjaga keamanan akun Anda:</p>
                    <ul>
                        <li>Jangan pernah berbagi password dengan orang lain</li>
                        <li>Gunakan password yang berbeda untuk setiap akun</li>
                        <li>Ganti password secara berkala (3-6 bulan sekali)</li>
                        <li>Logout setelah selesai menggunakan sistem</li>
                        <li>Jangan akses akun dari komputer umum/warnet</li>
                    </ul>
                    
                    <h3>❓ Troubleshooting</h3>
                    
                    <h4>Problem: Email reset tidak diterima</h4>
                    <p><strong>Solusi:</strong></p>
                    <ul>
                        <li>Cek folder Spam/Junk di email Anda</li>
                        <li>Pastikan email yang dimasukkan benar</li>
                        <li>Tunggu 5-10 menit, kadang email delay</li>
                        <li>Coba ulangi proses reset</li>
                    </ul>
                    
                    <h4>Problem: Link reset sudah expired</h4>
                    <p><strong>Solusi:</strong></p>
                    <ul>
                        <li>Link reset berlaku selama 1 jam</li>
                        <li>Ulangi proses reset password dari awal</li>
                        <li>Gunakan link yang baru dikirim</li>
                    </ul>
                    
                    <div style="background-color: #f8d7da; border: 1px solid #f5c6cb; padding: 15px; border-radius: 5px; margin: 20px 0;">
                        <strong>🆘 Butuh Bantuan?</strong><br>
                        Jika masih mengalami kesulitan, hubungi tim support kami:<br>
                        📞 Telp: (0751) xxx-xxxx<br>
                        📱 WhatsApp: 0856-xxxx-xxxx<br>
                        📧 Email: support@esurat-nagari.go.id<br>
                        🕐 Jam Kerja: 08:00 - 16:00 WIB
                    </div>',
                'slug' => 'tutorial-cara-reset-password-akun-e-surat',
                'author' => 'Tim IT Support',
                'status' => 'published',
            ],

            // Draft content
            [
                'kategori_koten_id' => $kategoris->where('slug', 'berita-umum')->first()->id ?? $kategoris->first()->id,
                'title' => 'Rencana Pembangunan Balai Nagari Baru Tahun 2026',
                'body' => '<h2>Pembangunan Balai Nagari untuk Pelayanan yang Lebih Prima</h2>
                    <p>Dalam rangka meningkatkan kualitas pelayanan kepada masyarakat, Pemerintah Nagari merencanakan pembangunan Balai Nagari baru pada tahun 2026 mendatang.</p>
                    
                    <h3>Latar Belakang</h3>
                    <p>Balai Nagari yang ada saat ini sudah tidak memadai untuk melayani kebutuhan masyarakat yang terus berkembang. Diperlukan fasilitas yang lebih modern dan nyaman untuk mendukung pelayanan publik yang optimal.</p>
                    
                    <p><em>Artikel ini masih dalam tahap penyusunan...</em></p>',
                'slug' => 'rencana-pembangunan-balai-nagari-baru-tahun-2026',
                'author' => 'Bagian Perencanaan',
                'status' => 'draft',
            ],
        ];

        foreach ($kontens as $konten) {
            // Cek apakah konten dengan slug yang sama sudah ada
            if (!Konten::where('slug', $konten['slug'])->exists()) {
                Konten::create($konten);
            }
        }

        $this->command->info('Konten seeder berhasil dijalankan!');
        $this->command->info('Total konten yang ditambahkan: ' . count($kontens));
    }
}
