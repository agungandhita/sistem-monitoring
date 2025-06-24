-- -------------------------------------------------------------
-- TablePlus 6.4.8(608)
--
-- https://tableplus.com/
--
-- Database: sismo
-- Generation Time: 2025-06-21 14:25:03.1230
-- -------------------------------------------------------------


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


INSERT INTO `catatan_perkembangans` (`catatan_id`, `siswa_id`, `guru_id`, `tanggal`, `jenis_catatan`, `catatan`, `semester`, `tahun_ajaran`, `created_at`, `updated_at`) VALUES
(1, 1, 1, '2025-06-21', 'perilaku', 'anakmu betik polll', '2', '2024/2025', '2025-06-21 13:44:18', '2025-06-21 13:44:18'),
(2, 2, 1, '2025-06-21', 'akademik', 'anakmu pinter', '2', '2024/2025', '2025-06-21 13:49:31', '2025-06-21 13:49:31');

INSERT INTO `guru_mapel` (`id`, `guru_id`, `mapel_id`, `kurikulum_id`, `kelas_id`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 1, 1, '2025-06-21 13:36:36', '2025-06-21 13:36:36');

INSERT INTO `gurus` (`guru_id`, `nuptk`, `nip`, `nama`, `jenis_kelamin`, `foto`, `alamat`, `tanggal_lahir`, `nomor_hp`, `email`, `password`, `jabatan`, `tahun_masuk`, `created_at`, `updated_at`) VALUES
(1, '1234567890123456', '198501012010011001', 'Dr. Ahmad Hidayat, S.Pd., M.Pd.', 'laki-laki', '1750487566_logo MIM.png', 'parengan', '2001-06-12', '081234567890', 'guru@gmail.com', '$2y$12$.zqFEtulMeBdxSAdKPEOOOrVfcILF7YZISd0Pgtdk78rNOQrVOpXC', 'wali kelas', '2025', '2025-06-21 13:32:46', '2025-06-21 13:32:46');

INSERT INTO `jadwals` (`jadwal_id`, `hari`, `jam_ke`, `jam_mulai`, `jam_selesai`, `mapel_id`, `guru_id`, `kelas_id`, `kurikulum_id`, `tahun_ajaran`, `status`, `catatan`, `created_at`, `updated_at`) VALUES
(1, 'Senin', 1, '07:00:00', '07:45:00', 1, 1, 1, 1, '2024/2025', 'aktif', 'jadwal baru', '2025-06-21 13:39:55', '2025-06-21 13:39:55');

INSERT INTO `kelas` (`kelas_id`, `nama_kelas`, `tingkat`, `tahun_ajaran`, `kurikulum_id`, `kapasitas`, `status`, `created_at`, `updated_at`) VALUES
(1, '1A', 1, '2025/2026', 1, 20, 'aktif', '2025-06-21 13:34:50', '2025-06-21 13:34:50');

INSERT INTO `kurikulums` (`kurikulum_id`, `nama_kurikulum`, `tahun_ajaran`, `created_at`, `updated_at`) VALUES
(1, 'kurikulum sak karep ku', '2024/2025', '2025-06-21 13:30:19', '2025-06-21 13:30:19');

INSERT INTO `mapels` (`mapel_id`, `kode_mapel`, `mapel`, `deskripsi`, `kurikulum_id`, `created_at`, `updated_at`) VALUES
(1, 'MTK', 'Matematika', 'kelas 1', 1, '2025-06-21 13:31:07', '2025-06-21 13:31:07');

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_reset_tokens_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(5, '2025_06_10_093405_create_walis_table', 1),
(6, '2025_06_11_120500_create_kurikulums_table', 1),
(7, '2025_06_11_120600_create_mapels_table', 1),
(8, '2025_06_11_120611_create_gurus_table', 1),
(9, '2025_06_11_130000_create_kelas_table', 1),
(10, '2025_06_11_130100_create_siswas_table', 1),
(11, '2025_06_11_130150_create_wali_siswa_table', 1),
(12, '2025_06_11_130200_create_guru_mapel_table', 1),
(13, '2025_06_11_130300_create_jadwals_table', 1),
(14, '2025_06_17_111511_create_nilai_harians_table', 1),
(15, '2025_06_17_111815_create_catatan_perkembangans_table', 1);

INSERT INTO `nilai_harians` (`nilai_id`, `siswa_id`, `guru_id`, `mapel_id`, `kelas_id`, `tanggal`, `nilai`, `jenis_penilaian`, `keterangan`, `semester`, `tahun_ajaran`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 1, 1, '2025-06-21', 60.00, 'Tugas', 'goblok', 'Genap', '2025/2026', '2025-06-21 13:43:06', '2025-06-21 13:43:06'),
(2, 1, 1, 1, 1, '2025-06-21', 70.00, 'Ulangan Harian', 'ulamgam harian', 'Genap', '2025/2026', '2025-06-21 13:43:48', '2025-06-21 13:43:48'),
(3, 2, 1, 1, 1, '2025-06-21', 90.00, 'Praktik', NULL, 'Genap', '2025/2026', '2025-06-21 13:48:57', '2025-06-21 13:48:57'),
(4, 2, 1, 1, 1, '2025-06-21', 89.00, 'Kuis', NULL, 'Genap', '2025/2026', '2025-06-21 13:49:08', '2025-06-21 13:49:08');

INSERT INTO `siswas` (`siswa_id`, `kelas_id`, `nis`, `nama`, `jenis_kelamin`, `tanggal_lahir`, `tempat_lahir`, `alamat`, `telepon`, `tahun_masuk`, `status`, `catatan`, `created_at`, `updated_at`) VALUES
(1, 1, '07.1.2020.0019', 'Marsudi Tambak', 'L', '2001-06-12', 'gresik', 'parengan', '082231719219', '2025', 'aktif', 'murid baru', '2025-06-21 13:39:11', '2025-06-21 13:39:11'),
(2, 1, '07.1.2020.0014', 'john', 'P', '2001-06-12', 'Lamongan', 'okeee', '082231719219', '2025', 'aktif', 'mbohhh kono', '2025-06-21 13:47:54', '2025-06-21 13:47:54');

INSERT INTO `users` (`user_id`, `nama`, `alamat`, `telepon`, `email`, `email_verified_at`, `password`, `role`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Admin', 'Jl. Admin No. 1', '08123456789', 'admin@sismo.com', NULL, '$2y$12$rGAyw6PIO764tbsii1L3AuyLR6IxGvogwN8ut8Ntqj1velyLn7Cwe', 'admin', NULL, '2025-06-18 08:20:34', '2025-06-18 08:20:34'),
(2, 'miftahul khoiri', 'parengan', '082231719219', 'wali@gmail.com', NULL, '$2y$12$H8SZ7D3BLyEjRJyuiaErc.JjTNzGS.wsR2dam76JYa8t6/MU5VLyC', 'wali', NULL, '2025-06-21 13:37:46', '2025-06-21 13:37:46');

INSERT INTO `wali_siswa` (`id`, `wali_id`, `siswa_id`, `hubungan`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 'ayah', '2025-06-21 13:39:11', '2025-06-21 13:39:11'),
(2, 1, 2, 'kakek', '2025-06-21 13:47:54', '2025-06-21 13:47:54');

INSERT INTO `walis` (`wali_id`, `user_id`, `nama`, `alamat`, `telepon`, `pekerjaan`, `jenis_kelamin`, `created_at`, `updated_at`) VALUES
(1, 2, 'miftahul khoiri', 'parengan', '082231719219', 'mabar ep ep', 'L', '2025-06-21 13:37:46', '2025-06-21 13:37:46');



/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;