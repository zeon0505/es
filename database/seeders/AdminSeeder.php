<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Slide;
use App\Models\Kategori;
use App\Models\Berita;
use App\Models\Dosen;
use App\Models\Poster;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();

        // ── Admin Users ──
        User::updateOrCreate(
            ['email' => 'yoga@staimas.com'],
            [
                'name'      => 'Yoga',
                'password'  => Hash::make('stmas123'),
                'is_admin'  => true,
            ]
        );

        User::updateOrCreate(
            ['email' => 'naufal@staimas.com'],
            [
                'name'      => 'Naufal',
                'password'  => Hash::make('stmas123'),
                'is_admin'  => true,
            ]
        );

        User::updateOrCreate(
            ['email' => 'syafikah@staimas.com'],
            [
                'name'      => 'Syafikah',
                'password'  => Hash::make('stmas123'),
                'is_admin'  => true,
            ]
        );

        // ── Slides ──
        Slide::truncate();
        $slides = [
            ['judul' => 'Mahasiswa Ekonomi Syariah STAIMAS Wonogiri', 'gambar' => 'slides/slide1.png', 'urutan' => 1, 'aktif' => true],
            ['judul' => 'Kegiatan Kuliah Lapangan Ekonomi Syariah',   'gambar' => 'slides/slide2.png', 'urutan' => 2, 'aktif' => true],
        ];
        foreach ($slides as $s) {
            Slide::create($s);
        }

        // ── Kategori Berita ──
        Kategori::truncate();
        $kategoris = [
            ['nama' => 'Kegiatan',   'slug' => 'kegiatan'],
            ['nama' => 'Prestasi',   'slug' => 'prestasi'],
            ['nama' => 'Akademik',   'slug' => 'akademik'],
            ['nama' => 'Pengabdian', 'slug' => 'pengabdian'],
        ];
        foreach ($kategoris as $k) {
            Kategori::create($k);
        }

        $katKegiatan   = Kategori::where('slug', 'kegiatan')->first();
        $katPrestasi   = Kategori::where('slug', 'prestasi')->first();
        $katAkademik   = Kategori::where('slug', 'akademik')->first();
        $katPengabdian = Kategori::where('slug', 'pengabdian')->first();

        // ── Berita ──
        Berita::truncate();
        $beritas = [
            [
                'kategori_id' => $katKegiatan->id,
                'judul'       => 'Praktek Sidang Keuangan Syariah Mahasiswa Ekonomi Syariah',
                'slug'        => 'praktek-sidang-keuangan-syariah',
                'konten'      => 'Program Studi Ekonomi Syariah STAIMAS Wonogiri menyelenggarakan praktikum simulasi analisis laporan keuangan syariah dan kepatuhan akad perbankan syariah. Mahasiswa diharapkan menguasai seluk beluk operasional lembaga keuangan Islam modern sebelum masuk ke dunia industri nyata.',
                'gambar'      => null,
                'tanggal'     => '2026-07-02',
                'aktif'       => true,
            ],
            [
                'kategori_id' => $katPrestasi->id,
                'judul'       => 'Mahasiswa Ekonomi Syariah Juara Business Plan Competition',
                'slug'        => 'juara-business-plan-competition',
                'konten'      => 'Delegasi mahasiswa Program Studi Ekonomi Syariah (ES) STAIMAS Wonogiri berhasil meraih juara pertama dalam ajang kompetisi rencana bisnis syariah tingkat nasional. Konsep startup digital berbasis wakaf produktif yang mereka usung dinilai sangat inovatif dan berdaya guna.',
                'gambar'      => null,
                'tanggal'     => '2026-06-15',
                'aktif'       => true,
            ],
            [
                'kategori_id' => $katAkademik->id,
                'judul'       => 'Seminar Nasional: Masa Depan Fintech Syariah di Indonesia',
                'slug'        => 'seminar-fintech-syariah',
                'konten'      => 'Seminar ini membahas peluang dan tantangan perkembangan financial technology (fintech) berbasis nilai syariah di Indonesia. Digitalisasi instrumen ekonomi Islam seperti zakat dan infak digital menjadi salah satu topik paling hangat dibahas.',
                'gambar'      => null,
                'tanggal'     => '2026-06-05',
                'aktif'       => true,
            ],
        ];
        foreach ($beritas as $b) {
            Berita::create($b);
        }

        // ── Dosen ──
        Dosen::truncate();
        $dosens = [
            ['nama' => 'Drs. H. Mulyanto, M.M.',        'jabatan' => 'Ketua Program Studi',  'foto' => 'https://www.staimaswonogiri.ac.id/wp-content/uploads/2025/07/Pak-abdul.png',    'urutan' => 1],
            ['nama' => 'Indah Puspita, S.E., M.E.S.',   'jabatan' => 'Dosen Tetap ES',       'foto' => 'https://www.staimaswonogiri.ac.id/wp-content/uploads/2025/07/bu-ratih.png',    'urutan' => 2],
            ['nama' => 'Dr. Rahmat Hidayat, M.E.I.',    'jabatan' => 'Dosen Tetap ES',       'foto' => 'https://www.staimaswonogiri.ac.id/wp-content/uploads/2025/07/pak-amir.png',     'urutan' => 3],
        ];
        foreach ($dosens as $d) {
            Dosen::create(array_merge($d, ['aktif' => true]));
        }

        // ── Poster ──
        Poster::truncate();
        $posters = [
            ['judul' => 'PMB Ekonomi Syariah 2025', 'deskripsi' => 'Buka Pendaftaran Mahasiswa Baru Program Studi Ekonomi Syariah', 'gambar' => null, 'kategori' => 'PMB'],
            ['judul' => 'Beasiswa Kemitraan',        'deskripsi' => 'Info Beasiswa Khusus Mahasiswa Ekonomi Syariah',               'gambar' => null, 'kategori' => 'Beasiswa'],
            ['judul' => 'Kuliah Kerja Usaha',        'deskripsi' => 'Pendaftaran Magang dan Kunjungan Industri 2026',               'gambar' => null, 'kategori' => 'Kegiatan'],
        ];
        foreach ($posters as $p) {
            Poster::create(array_merge($p, ['aktif' => true]));
        }

        Schema::enableForeignKeyConstraints();
    }
}