# Dokumentasi Data Seeder SISMO

## Overview
Dokumentasi ini menjelaskan cara menjalankan data seeder untuk mengisi database dengan data dummy yang dapat digunakan untuk menguji semua fungsi sistem SISMO, khususnya fitur Nilai Harian dan Catatan Perkembangan.

## Seeder yang Tersedia

### 1. Seeder Dasar (Sudah Ada)
- **UserSeeder**: Membuat user admin
- **KurikulumSeeder**: Data kurikulum sekolah
- **MapelSeeder**: Data mata pelajaran
- **GuruMapelSeeder**: Relasi guru dengan mata pelajaran
- **KelasSeeder**: Data kelas (1A, 1B, 2A, dst.)
- **WaliSeeder**: Data wali siswa
- **SiswaSeeder**: Data siswa
- **GuruSeeder**: Data guru
- **JadwalSeeder**: Data jadwal pembelajaran

### 2. Seeder Baru (Untuk Fitur Nilai Harian & Catatan Perkembangan)
- **WaliSiswaSeeder**: Relasi wali dengan siswa yang diasuh
- **NilaiHarianSeeder**: Data nilai harian siswa (3 bulan terakhir)
- **CatatanPerkembanganSeeder**: Data catatan perkembangan siswa (4 bulan terakhir)

## Cara Menjalankan Seeder

### 1. Menjalankan Semua Seeder
```bash
php artisan db:seed
```

### 2. Menjalankan Seeder Tertentu
```bash
# Hanya nilai harian
php artisan db:seed --class=NilaiHarianSeeder

# Hanya catatan perkembangan
php artisan db:seed --class=CatatanPerkembanganSeeder

# Hanya relasi wali-siswa
php artisan db:seed --class=WaliSiswaSeeder
```

### 3. Reset Database dan Jalankan Ulang
```bash
php artisan migrate:fresh --seed
```

## Data yang Dihasilkan

### NilaiHarianSeeder
- **Jumlah**: 8-15 nilai per siswa per mata pelajaran
- **Periode**: 3 bulan terakhir
- **Jenis Penilaian**: Tugas, Kuis, Ulangan Harian, Praktik, Lainnya
- **Distribusi Nilai**:
  - 70% nilai bagus (75-100)
  - 20% nilai sedang (60-74)
  - 10% nilai kurang (50-59)
- **Keterangan**: Otomatis berdasarkan nilai (positif/negatif)
- **Semester & Tahun Ajaran**: Otomatis berdasarkan tanggal

### CatatanPerkembanganSeeder
- **Jumlah**: 3-8 catatan per siswa
- **Periode**: 4 bulan terakhir
- **Distribusi Catatan**:
  - 50% catatan positif
  - 30% catatan observasi/netral
  - 20% catatan yang perlu perbaikan
- **Guru**: Random dari guru yang mengajar di kelas siswa

### WaliSiswaSeeder
- **Relasi**: Setiap wali mengasuh 1-3 siswa
- **Hubungan**: Ayah, Ibu, Kakek, Nenek, Paman, Bibi, Wali
- **Memastikan**: Semua siswa memiliki wali

## Fungsi yang Dapat Diuji

### Untuk Guru
1. **Input Nilai Harian**
   - Login sebagai guru
   - Akses `/guru/nilai-harian`
   - Pilih kelas dan mata pelajaran
   - Input nilai untuk siswa

2. **Input Catatan Perkembangan**
   - Login sebagai guru
   - Akses `/guru/catatan-perkembangan`
   - Pilih siswa dan input catatan

### Untuk Wali
1. **Lihat Nilai Harian Anak**
   - Login sebagai wali
   - Akses `/wali/nilai-harian`
   - Pilih anak yang diasuh
   - Lihat nilai bulan ini

2. **Lihat Riwayat Nilai**
   - Dari halaman nilai harian
   - Klik "Lihat Riwayat"
   - Filter berdasarkan mata pelajaran, semester, tahun ajaran

3. **Lihat Catatan Perkembangan**
   - Login sebagai wali
   - Akses `/wali/catatan-perkembangan`
   - Lihat catatan dari guru

### Untuk Admin
1. **Monitor Nilai Harian**
   - Login sebagai admin
   - Akses `/admin/nilai-harian`
   - Filter berdasarkan kelas, mata pelajaran, bulan
   - Lihat statistik kelas

2. **Laporan Nilai Harian**
   - Dari halaman admin nilai harian
   - Klik "Lihat Laporan"
   - Filter berdasarkan kelas, semester, tahun ajaran
   - Lihat rekap per siswa per mata pelajaran

3. **Monitor Catatan Perkembangan**
   - Login sebagai admin
   - Akses `/admin/catatan-perkembangan`
   - Filter dan lihat semua catatan

## Akun Login Default

### Admin
- **Email**: admin@sekolah.com
- **Password**: password123

### Guru
- **Email**: ahmad.hidayat@sekolah.com (dan guru lainnya)
- **Password**: password123

### Wali
- **Email**: ahmad.suryanto@email.com (dan wali lainnya)
- **Password**: password123

## Tips Pengujian

1. **Jalankan seeder setelah migrasi**:
   ```bash
   php artisan migrate:fresh --seed
   ```

2. **Cek data yang dihasilkan**:
   ```bash
   php artisan tinker
   >>> App\Models\NilaiHarian::count()
   >>> App\Models\CatatanPerkembangan::count()
   ```

3. **Test berbagai filter**:
   - Filter berdasarkan kelas
   - Filter berdasarkan mata pelajaran
   - Filter berdasarkan bulan/semester
   - Filter berdasarkan tahun ajaran

4. **Test perhitungan statistik**:
   - Rata-rata nilai per siswa
   - Rata-rata nilai per mata pelajaran
   - Rata-rata nilai per kelas
   - Nilai tertinggi dan terendah

5. **Test fitur export** (jika sudah diimplementasi):
   - Export data nilai harian
   - Export laporan rekap

## Troubleshooting

### Error: Data tidak muncul
- Pastikan semua seeder dasar sudah dijalankan
- Cek apakah ada error saat menjalankan seeder
- Pastikan relasi antar tabel sudah benar

### Error: Guru tidak bisa input nilai
- Pastikan GuruMapelSeeder sudah dijalankan
- Cek apakah guru sudah diassign ke mata pelajaran
- Pastikan kelas sudah memiliki siswa

### Error: Wali tidak bisa lihat data anak
- Pastikan WaliSiswaSeeder sudah dijalankan
- Cek relasi wali_siswa di database
- Pastikan wali sudah login dengan benar

Dengan data seeder ini, semua fungsi sistem SISMO dapat diuji secara komprehensif dengan data yang realistis.