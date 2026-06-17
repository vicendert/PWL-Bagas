<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Role;
use App\Models\Cabang;
use App\Models\HubPusat;
use App\Models\KategoriLapangan;
use App\Models\MemberGroup;
use App\Models\Lapangan;
use App\Models\SaranaFasilitas;
use App\Models\MusimOperasional;
use App\Models\TarifSkema;
use App\Models\StandarFasilitas;
use App\Models\SlotWaktu;
use App\Models\TargetKeterisian;
use App\Models\Pemesanan;
use App\Models\StafQC;
use App\Models\KategoriTemuan;
use App\Models\RekapKelayakan;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Roles
        $adminRole = Role::create([
            'name' => 'admin_pusat',
            'display_name' => 'Admin Pusat',
            'description' => 'Administrator dengan kontrol penuh sistem.'
        ]);
        $kasirRole = Role::create([
            'name' => 'kasir',
            'display_name' => 'Kasir',
            'description' => 'Staf backoffice pengelola transaksi.'
        ]);
        $spvRole = Role::create([
            'name' => 'supervisor',
            'display_name' => 'Supervisor',
            'description' => 'Pengawas operasional lapangan.'
        ]);
        $memberRole = Role::create([
            'name' => 'member',
            'display_name' => 'Member / Penyewa',
            'description' => 'Akun portal untuk menyewa lapangan.'
        ]);

        // 2. Cabang
        $cabangJKT = Cabang::create([
            'nama_cabang' => 'Cabang Jakarta Selatan',
            'keterangan' => 'Gedung Olahraga Pancoran',
            'alamat' => 'Jl. Gatot Subroto No.10, Pancoran, Jakarta Selatan',
            'telepon' => '021-5551234',
            'is_active' => true
        ]);
        $cabangBDG = Cabang::create([
            'nama_cabang' => 'Cabang Bandung Wetan',
            'keterangan' => 'Stadion Siliwangi Area',
            'alamat' => 'Jl. Lombok No.5, Bandung',
            'telepon' => '022-4445678',
            'is_active' => true
        ]);

        // 3. Hub Pusat
        $hubBadminton = HubPusat::create([
            'nama_hub' => 'Hub Induk Badminton Nasional',
            'deskripsi' => 'Pengawas standar fasilitas badminton seluruh Indonesia'
        ]);
        $hubFutsal = HubPusat::create([
            'nama_hub' => 'Hub Asosiasi Futsal Indonesia',
            'deskripsi' => 'Pengawas standar fasilitas futsal berlisensi'
        ]);

        // 4. Kategori Lapangan
        $katBadminton = KategoriLapangan::create([
            'nama_kategori' => 'Badminton',
            'icon' => 'sports_tennis',
            'deskripsi' => 'Lapangan bulutangkis indoor'
        ]);
        $katFutsal = KategoriLapangan::create([
            'nama_kategori' => 'Futsal',
            'icon' => 'sports_soccer',
            'deskripsi' => 'Lapangan futsal indoor/outdoor'
        ]);

        // 5. Member Groups
        $groupReg = MemberGroup::create([
            'name' => 'Regular Member',
            'description' => 'Penyewa umum tanpa diskon khusus.'
        ]);
        $groupVIP = MemberGroup::create([
            'name' => 'VIP Member',
            'description' => 'Penyewa setia dengan diskon 10%.'
        ]);

        // 6. Users
        // Admin
        User::create([
            'role_id' => $adminRole->id,
            'name' => 'Admin Pusat',
            'email' => 'admin@sewalapangan.com',
            'username' => 'admin',
            'password' => Hash::make('admin123'),
            'is_active' => true
        ]);
        // Staf / Backoffice
        User::create([
            'role_id' => $kasirRole->id,
            'cabang_id' => $cabangJKT->id,
            'name' => 'Budi Kasir',
            'email' => 'budi@sewalapangan.com',
            'username' => 'budi_kasir',
            'password' => Hash::make('password'),
            'is_active' => true
        ]);
        // Supervisor
        User::create([
            'role_id' => $spvRole->id,
            'cabang_id' => $cabangJKT->id,
            'name' => 'Andi Supervisor',
            'email' => 'andi@sewalapangan.com',
            'username' => 'andi_spv',
            'password' => Hash::make('password'),
            'is_active' => true
        ]);
        // Portal Member
        User::create([
            'role_id' => $memberRole->id,
            'member_group_id' => $groupVIP->id,
            'name' => 'Rian Wijaya',
            'email' => 'rian@gmail.com',
            'username' => 'rian_wijaya',
            'password' => Hash::make('password'),
            'is_active' => true
        ]);

        // 7. Lapangan
        $lapA = Lapangan::create([
            'hub_pusat_id' => $hubBadminton->id,
            'kategori_lapangan_id' => $katBadminton->id,
            'cabang_id' => $cabangJKT->id,
            'kode' => 'LAP-BDM-01',
            'nama_lapangan' => 'Lapangan Badminton VVIP Jakarta',
            'akreditasi' => 'Unggul',
            'nomor_sk' => 'SK/LAP/2026/001',
            'tanggal_sertifikasi' => '2026-01-15',
            'alamat' => 'Gedung A, Lt. 1, Pancoran',
            'is_active' => true
        ]);
        $lapB = Lapangan::create([
            'hub_pusat_id' => $hubFutsal->id,
            'kategori_lapangan_id' => $katFutsal->id,
            'cabang_id' => $cabangJKT->id,
            'kode' => 'LAP-FUT-01',
            'nama_lapangan' => 'Lapangan Futsal Siliwangi 1',
            'akreditasi' => 'A',
            'nomor_sk' => 'SK/LAP/2026/002',
            'tanggal_sertifikasi' => '2026-02-20',
            'alamat' => 'Gedung B, Lt. 1, Pancoran',
            'is_active' => true
        ]);

        // 8. Sarana Fasilitas
        SaranaFasilitas::create([
            'lapangan_id' => $lapA->id,
            'kode_fasilitas' => 'SF-LK-01',
            'nama_unit' => 'Loker Atlet Premium',
            'alamat' => 'Lt. 1 samping lapangan 1'
        ]);
        SaranaFasilitas::create([
            'lapangan_id' => $lapB->id,
            'kode_fasilitas' => 'SF-KM-02',
            'nama_unit' => 'Kamar Mandi Air Hangat',
            'alamat' => 'Lt. 1 samping ruang ganti'
        ]);

        // 9. Musim Operasional
        MusimOperasional::create([
            'tahun' => 2026,
            'status' => 'Aktif'
        ]);
        MusimOperasional::create([
            'tahun' => 2025,
            'status' => 'Tidak Aktif'
        ]);

        // 10. Tarif Skema
        TarifSkema::create([
            'cabang_id' => $cabangJKT->id,
            'tahun' => 2026,
            'nilai_tarif' => 150000.00,
            'deskripsi_skema_jam' => 'Malam (18:00 - 22:00)',
            'periode' => 'Musim Reguler',
            'lokasi_lapangan' => 'Jakarta Selatan'
        ]);
        TarifSkema::create([
            'cabang_id' => $cabangJKT->id,
            'tahun' => 2026,
            'nilai_tarif' => 100000.00,
            'deskripsi_skema_jam' => 'Pagi (08:00 - 15:00)',
            'periode' => 'Musim Reguler',
            'lokasi_lapangan' => 'Jakarta Selatan'
        ]);

        // 11. Standar Fasilitas (Hierarchical)
        $parentSF = StandarFasilitas::create([
            'nama_fasilitas' => 'Lapangan Utama Badminton',
            'deskripsi' => '<p>Spesifikasi dasar lantai kayu jati dengan garis batas berstandar BWF.</p>',
            'jenis_indikator' => 'kualitatif',
            'bobot_kelayakan' => 60.00,
            'urutan' => 1
        ]);
        StandarFasilitas::create([
            'parent_id' => $parentSF->id,
            'nama_fasilitas' => 'Lampu Sorot LED 500W',
            'deskripsi' => '<p>Penerangan minimal 500 lux di atas lapangan tanpa silau.</p>',
            'jenis_indikator' => 'kuantitatif',
            'bobot_kelayakan' => 20.00,
            'urutan' => 2
        ]);
        StandarFasilitas::create([
            'parent_id' => $parentSF->id,
            'nama_fasilitas' => 'Net Bulutangkis Standar BWF',
            'deskripsi' => '<p>Ketinggian tiang penyangga net adalah 1.55 meter.</p>',
            'jenis_indikator' => 'kualitatif',
            'bobot_kelayakan' => 20.00,
            'urutan' => 3
        ]);

        // 12. Slot Waktu
        $slot1 = SlotWaktu::create([
            'lapangan_id' => $lapA->id,
            'tanggal_mulai' => '2026-06-01',
            'tanggal_selesai' => '2026-06-30',
            'tipe_slot' => 'Reguler'
        ]);
        $slot2 = SlotWaktu::create([
            'lapangan_id' => $lapB->id,
            'tanggal_mulai' => '2026-07-01',
            'tanggal_selesai' => '2026-07-07',
            'tipe_slot' => 'Turnamen'
        ]);

        // 13. Target Keterisian
        TargetKeterisian::create([
            'lapangan_id' => $lapA->id,
            'tahun' => 2026,
            'bulan' => 6,
            'target_jam' => 120,
            'realisasi_jam' => 85
        ]);
        TargetKeterisian::create([
            'lapangan_id' => $lapB->id,
            'tahun' => 2026,
            'bulan' => 6,
            'target_jam' => 100,
            'realisasi_jam' => 40
        ]);

        // 14. Pemesanan
        Pemesanan::create([
            'user_id' => 4, // Rian Wijaya
            'lapangan_id' => $lapA->id,
            'slot_waktu_id' => $slot1->id,
            'tanggal' => '2026-06-18',
            'jam_mulai' => '19:00:00',
            'jam_selesai' => '21:00:00',
            'total_biaya' => 300000.00,
            'status' => 'Aktif'
        ]);

        // 15. Staf QC
        StafQC::create([
            'nik' => 'QC-3174-001',
            'nama_staf' => 'Eko Prasetyo',
            'gelar' => 'S.T.',
            'jenis_kelamin' => 'L',
            'jabatan' => 'Senior QC Inspector',
            'cabang_id' => $cabangJKT->id,
            'lapangan_id' => $lapA->id
        ]);

        // 16. Kategori Temuan
        KategoriTemuan::create([
            'nama_temuan' => 'Lantai Licin',
            'jenis_temuan' => 'Negatif'
        ]);
        KategoriTemuan::create([
            'nama_temuan' => 'Penerangan Sangat Bagus',
            'jenis_temuan' => 'Positif'
        ]);

        // 17. Rekap Kelayakan
        RekapKelayakan::create([
            'lapangan_id' => $lapA->id,
            'target_keterisian_jam' => 120,
            'nilai_kondisi_mandiri' => 85.50,
            'nilai_tim_qc' => 88.00,
            'grade' => 'A',
            'bintang' => 5
        ]);
        RekapKelayakan::create([
            'lapangan_id' => $lapB->id,
            'target_keterisian_jam' => 100,
            'nilai_kondisi_mandiri' => 70.00,
            'nilai_tim_qc' => 75.00,
            'grade' => 'B',
            'bintang' => 4
        ]);
    }
}
