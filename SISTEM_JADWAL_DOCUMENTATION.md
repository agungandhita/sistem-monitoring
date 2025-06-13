# Dokumentasi Sistem Monitoring Pembelajaran Harian SD

## Overview
Sistem ini dirancang untuk mengelola jadwal pembelajaran harian di jenjang Sekolah Dasar (SD) dengan fitur monitoring yang komprehensif.

## Struktur Database

### Tabel Utama

#### 1. `kelas`
Menyimpan informasi kelas dari tingkat 1-6 SD.
```sql
- kelas_id (Primary Key)
- nama_kelas (contoh: "1A", "2B", "3C")
- tingkat (1-6 untuk SD)
- tahun_ajaran (contoh: "2024/2025")
- kurikulum_id (Foreign Key ke kurikulums)
- kapasitas (default: 30)
- status (aktif/tidak_aktif)
- timestamps
```

#### 2. `siswas` (Dimodifikasi)
Tabel siswa yang sudah diperbarui untuk menggunakan relasi kelas.
```sql
- siswa_id (Primary Key)
- nis, nama, jenis_kelamin, tanggal_lahir, tempat_lahir
- alamat, telepon
- kelas_id (Foreign Key ke kelas) -- BARU
- tahun_masuk, status, catatan
- timestamps
```

#### 3. `guru_mapel` (Dimodifikasi)
Tabel pivot yang menghubungkan guru dengan mata pelajaran untuk kelas tertentu.
```sql
- id (Primary Key)
- guru_id (Foreign Key ke gurus)
- mapel_id (Foreign Key ke mapels)
- kurikulum_id (Foreign Key ke kurikulums)
- kelas_id (Foreign Key ke kelas) -- BARU
- timestamps
```

#### 4. `jadwals` (Baru)
Tabel utama untuk menyimpan jadwal pelajaran harian.
```sql
- jadwal_id (Primary Key)
- hari (Senin-Sabtu)
- jam_ke (1, 2, 3, dst)
- jam_mulai, jam_selesai
- mapel_id (Foreign Key ke mapels)
- guru_id (Foreign Key ke gurus)
- kelas_id (Foreign Key ke kelas)
- kurikulum_id (Foreign Key ke kurikulums)
- tahun_ajaran
- status (aktif/tidak_aktif)
- catatan
- timestamps
```

### Validasi dan Constraints

1. **Unique Constraints pada `kelas`:**
   - `nama_kelas` + `tahun_ajaran` harus unik

2. **Unique Constraints pada `guru_mapel`:**
   - `guru_id` + `mapel_id` + `kelas_id` + `kurikulum_id` harus unik

3. **Unique Constraints pada `jadwals`:**
   - `hari` + `jam_ke` + `kelas_id` + `tahun_ajaran` (mencegah bentrok kelas)
   - `hari` + `jam_ke` + `guru_id` + `tahun_ajaran` (mencegah bentrok guru)

## Relasi Eloquent

### Model Kelas
```php
// One-to-Many
$kelas->siswas()      // Siswa dalam kelas
$kelas->jadwals()     // Jadwal kelas
$kelas->guruMapels()  // Guru-mapel yang mengajar

// Many-to-One
$kelas->kurikulum()   // Kurikulum yang digunakan

// Many-to-Many
$kelas->gurus()       // Guru yang mengajar di kelas
$kelas->mapels()      // Mapel yang diajarkan di kelas
```

### Model Siswa
```php
// Many-to-One
$siswa->kelas()       // Kelas siswa

// Through relationship
$siswa->jadwals()     // Jadwal kelas siswa
```

### Model Guru
```php
// One-to-Many
$guru->jadwals()      // Jadwal mengajar guru

// Many-to-Many (updated)
$guru->mapels()       // Mapel yang diampu (dengan kelas_id)
$guru->kelas()        // Kelas yang diajar
$guru->kurikulums()   // Kurikulum yang diampu
```

### Model Jadwal
```php
// Many-to-One
$jadwal->mapel()      // Mata pelajaran
$jadwal->guru()       // Guru pengampu
$jadwal->kelas()      // Kelas yang dituju
$jadwal->kurikulum()  // Kurikulum yang berlaku
```

## Cara Penggunaan

### 1. Menampilkan Jadwal Per Hari Per Kelas
```php
// Jadwal kelas 1A hari Senin tahun ajaran 2024/2025
$jadwal = Jadwal::jadwalHarian('Senin', $kelasId, '2024/2025')
    ->with(['mapel', 'guru'])
    ->get();

foreach ($jadwal as $item) {
    echo "Jam {$item->jam_ke}: {$item->mapel->mapel} - {$item->guru->nama}";
}
```

### 2. Menampilkan Guru yang Mengajar di Jam Tertentu
```php
// Guru yang mengajar hari Senin jam ke-3 tahun ajaran 2024/2025
$jadwal = Jadwal::where('hari', 'Senin')
    ->where('jam_ke', 3)
    ->where('tahun_ajaran', '2024/2025')
    ->with(['guru', 'mapel', 'kelas'])
    ->get();
```

### 3. Menampilkan Daftar Siswa dalam Kelas Berdasarkan Tahun Ajaran
```php
// Siswa kelas 1A tahun ajaran 2024/2025
$kelas = Kelas::where('nama_kelas', '1A')
    ->where('tahun_ajaran', '2024/2025')
    ->with('siswas')
    ->first();

$siswas = $kelas->siswas;
```

### 4. Validasi Konflik Jadwal
```php
// Cek konflik sebelum membuat jadwal baru
$hasConflict = Jadwal::hasConflict(
    'Senin',        // hari
    3,              // jam_ke
    $kelasId,       // kelas_id
    $guruId,        // guru_id
    '2024/2025'     // tahun_ajaran
);

if (!$hasConflict) {
    // Aman untuk membuat jadwal
    Jadwal::create($jadwalData);
}
```

### 5. Query Kompleks dengan Scope
```php
// Jadwal guru tertentu hari ini
$jadwalGuru = Jadwal::jadwalGuru('Senin', $guruId, '2024/2025')
    ->with(['mapel', 'kelas'])
    ->get();

// Kelas aktif tingkat 1
$kelasSatu = Kelas::active()
    ->byTingkat(1)
    ->byTahunAjaran('2024/2025')
    ->get();
```

## Migration Files yang Dibuat

1. `2025_06_11_130000_create_kelas_table.php`
2. `2025_06_11_130100_modify_siswas_table_add_kelas_id.php`
3. `2025_06_11_130200_modify_guru_mapel_table_add_kelas_id.php`
4. `2025_06_11_130300_create_jadwals_table.php`

## Model Files yang Dibuat/Diperbarui

1. `app/Models/Kelas.php` (Baru)
2. `app/Models/Jadwal.php` (Baru)
3. `app/Models/Siswa.php` (Diperbarui)
4. `app/Models/Guru.php` (Diperbarui)
5. `app/Models/Mapel.php` (Diperbarui)
6. `app/Models/Kurikulum.php` (Diperbarui)

## Seeder Files

1. `database/seeders/KelasSeeder.php`
2. `database/seeders/JadwalSeeder.php`

## Menjalankan Migration dan Seeder

```bash
# Jalankan migration
php artisan migrate

# Jalankan seeder (pastikan urutan yang benar)
php artisan db:seed --class=KurikulumSeeder
php artisan db:seed --class=MapelSeeder
php artisan db:seed --class=GuruSeeder
php artisan db:seed --class=KelasSeeder
php artisan db:seed --class=GuruMapelSeeder
php artisan db:seed --class=SiswaSeeder
php artisan db:seed --class=JadwalSeeder
```

## Fitur Keamanan

1. **Validasi Bentrok Jadwal**: Sistem mencegah:
   - Satu kelas memiliki dua pelajaran di jam yang sama
   - Satu guru mengajar di dua kelas berbeda di jam yang sama

2. **Constraint Database**: Menggunakan unique constraints untuk memastikan integritas data

3. **Soft Validation**: Method `hasConflict()` untuk validasi sebelum insert

## Keunggulan Sistem

1. **Fleksibel**: Mendukung multiple kelas per tingkat (1A, 1B, dst)
2. **Scalable**: Mudah ditambah fitur monitoring dan reporting
3. **Maintainable**: Relasi yang jelas dan terstruktur
4. **User-friendly**: Query yang mudah untuk menampilkan jadwal
5. **Data Integrity**: Validasi yang ketat untuk mencegah konflik

Sistem ini siap digunakan untuk monitoring pembelajaran harian SD dengan kemampuan menampilkan jadwal per hari per kelas, tracking guru pengampu, dan manajemen siswa berdasarkan tahun ajaran.