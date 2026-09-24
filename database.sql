-- ===================================================
-- E-VOTE DATABASE MIGRATION & SEEDER SCRIPT
-- Database: `e_vote`
-- ===================================================

SET FOREIGN_KEY_CHECKS = 0;

DROP TABLE IF EXISTS `votes`;
DROP TABLE IF EXISTS `users`;
DROP TABLE IF EXISTS `voters`;
DROP TABLE IF EXISTS `candidates`;

SET FOREIGN_KEY_CHECKS = 1;

-- ---------------------------------------------------
-- 1. Table `candidates` (Data Pasangan Calon)
-- ---------------------------------------------------
CREATE TABLE `candidates` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `candidate_number` INT NOT NULL UNIQUE,
  `chairman_name` VARCHAR(150) NOT NULL,
  `vice_chairman_name` VARCHAR(150) NOT NULL,
  `vision` TEXT NOT NULL,
  `mission` TEXT NOT NULL,
  `photo` VARCHAR(255) DEFAULT NULL,
  `color` VARCHAR(20) DEFAULT '#6777ef',
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
  `updated_at` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ---------------------------------------------------
-- 2. Table `voters` (Daftar Pemilih Tetap / DPT)
-- ---------------------------------------------------
CREATE TABLE `voters` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `voter_code` VARCHAR(50) NOT NULL UNIQUE,
  `card_uid` VARCHAR(50) NULL UNIQUE,
  `name` VARCHAR(150) NOT NULL,
  `gender` ENUM('L', 'P') DEFAULT 'L',
  `class_or_dept` VARCHAR(100) NOT NULL,
  `has_voted` TINYINT(1) DEFAULT 0,
  `voted_at` DATETIME DEFAULT NULL,
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
  `updated_at` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ---------------------------------------------------
-- 3. Table `users` (Akun Login & RBAC)
-- ---------------------------------------------------
CREATE TABLE `users` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `name` VARCHAR(150) NOT NULL,
  `username` VARCHAR(100) NOT NULL UNIQUE,
  `password` VARCHAR(255) NOT NULL,
  `role` ENUM('admin', 'voter') NOT NULL DEFAULT 'voter',
  `card_uid` VARCHAR(50) NULL UNIQUE,
  `voter_id` INT NULL UNIQUE,
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
  `updated_at` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  CONSTRAINT `fk_users_voter` FOREIGN KEY (`voter_id`) REFERENCES `voters` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ---------------------------------------------------
-- 4. Table `votes` (Rekapitulasi Suara Masuk)
-- ---------------------------------------------------
CREATE TABLE `votes` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `voter_id` INT NOT NULL UNIQUE,
  `candidate_id` INT NOT NULL,
  `ip_address` VARCHAR(45) DEFAULT NULL,
  `voted_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
  CONSTRAINT `fk_votes_voter` FOREIGN KEY (`voter_id`) REFERENCES `voters` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_votes_candidate` FOREIGN KEY (`candidate_id`) REFERENCES `candidates` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ---------------------------------------------------
-- SEED DATA: CANDIDATES (Paslon)
-- ---------------------------------------------------
INSERT INTO `candidates` (`id`, `candidate_number`, `chairman_name`, `vice_chairman_name`, `vision`, `mission`, `photo`, `color`) VALUES
(1, 1, 'Muhammad Arya Pratama', 'Nadia Salsabila', 
 'Mewujudkan organisasi mahasiswa yang inklusif, inovatif, dan berdaya saing global dengan berlandaskan integritas dan kolaborasi aktif.',
 '1. Mengoptimalkan pelayanan advokasi dan kepedulian kesejahteraan seluruh mahasiswa.\n2. Mengembangkan ruang inkubasi inovasi digital dan kepemimpinan pemuda.\n3. Membangun sinergi kolaboratif lintas jurusan dan kemitraan eksternal industri.',
 'candidate-1.png', '#3abaf4'),

(2, 2, 'Bima Satria Nugraha', 'Siti Rahmawati', 
 'Membangun ekosistem kampus yang progresif, transparan, dan berdampak nyata bagi almamater serta masyarakat luas.',
 '1. Digitalisasi birokrasi dan transparansi keuangan secara terbuka dan akuntabel.\n2. Pemberdayaan minat, bakat, dan kewirausahaan mahasiswa berbasis riset aplikatif.\n3. Mengakselerasi program pengabdian masyarakat yang terpadu dan berkelanjutan.',
 'candidate-2.png', '#6777ef'),

(3, 3, 'Fajar Ramadhan', 'Clarissa Aurelia Putri', 
 'Menjadi wadah aspirasi yang adaptif, bersahabat, berbudaya prestasi, dan berorientasi pada masa depan era digital.',
 '1. Fasilitasi akselerasi karir dan sertifikasi bersama jejaring alumni nasional.\n2. Revitalisasi fasilitas penunjang kegiatan kreasi seni, teknologi, dan kebersamaan kampus.\n3. Kampanye lingkungan kampus hijau, kepedulian kesehatan mental, dan sportivitas.',
 'candidate-3.png', '#ffa426');

-- ---------------------------------------------------
-- SEED DATA: VOTERS (Pemilih DPT)
-- ---------------------------------------------------
INSERT INTO `voters` (`id`, `voter_code`, `card_uid`, `name`, `gender`, `class_or_dept`, `has_voted`, `voted_at`) VALUES
(1,  'VTR-2026-001', '0001002001', 'Ahmad Fauzi',         'L', 'Teknik Informatika A',  1, '2026-09-24 08:10:00'),
(2,  'VTR-2026-002', '0001002002', 'Anisa Rahma',         'P', 'Sistem Informasi B',   1, '2026-09-24 08:15:00'),
(3,  'VTR-2026-003', '0001002003', 'Dimas Anggara',       'L', 'Teknik Komputer',      1, '2026-09-24 08:22:00'),
(4,  'VTR-2026-004', '0001002004', 'Dinda Permata',       'P', 'Manajemen Informatika', 1, '2026-09-24 08:30:00'),
(5,  'VTR-2026-005', '0001002005', 'Eko Prasetyo',        'L', 'Teknik Informatika B',  1, '2026-09-24 08:35:00'),
(6,  'VTR-2026-006', '0001002006', 'Fitri Handayani',     'P', 'Sistem Informasi A',   1, '2026-09-24 08:41:00'),
(7,  'VTR-2026-007', '0001002007', 'Gilang Pratama',      'L', 'Teknik Elektro',       1, '2026-09-24 08:49:00'),
(8,  'VTR-2026-008', '0001002008', 'Hana Marwah',         'P', 'Teknik Komputer',      1, '2026-09-24 08:55:00'),
(9,  'VTR-2026-009', '0001002009', 'Irfan Hakim',         'L', 'Teknik Informatika A',  0, NULL),
(10, 'VTR-2026-010', '0001002010', 'Jessica Tan',         'P', 'Sistem Informasi B',   0, NULL),
(11, 'VTR-2026-011', '0001002011', 'Kevin Sanjaya',       'L', 'Teknik Informatika C',  0, NULL),
(12, 'VTR-2026-012', '0001002012', 'Laila Fitriani',      'P', 'Manajemen Informatika', 0, NULL),
(13, 'VTR-2026-013', '0001002013', 'Muhammad Rizki',      'L', 'Teknik Informatika B',  0, NULL),
(14, 'VTR-2026-014', '0001002014', 'Nurul Hidayah',       'P', 'Sistem Informasi A',   0, NULL),
(15, 'VTR-2026-015', '0001002015', 'Putra Perkasa',       'L', 'Teknik Elektro',       0, NULL);

-- ---------------------------------------------------
-- SEED DATA: USERS (Admin & Voters)
-- Passwords:
-- Admin: admin123
-- Voters: voter123
-- ---------------------------------------------------
INSERT INTO `users` (`id`, `name`, `username`, `password`, `role`, `card_uid`, `voter_id`) VALUES
(1, 'Administrator E-Vote', 'admin', '$2y$10$mEB31p4ZIc1OuKx8SgJApeQWF27LXBGLCauRZGSuYI75pQMke46aK', 'admin', '0000000001', NULL);

-- Seed voter user accounts (username = voter_code, password = voter123)
INSERT INTO `users` (`name`, `username`, `password`, `role`, `card_uid`, `voter_id`)
SELECT `name`, `voter_code`, '$2y$10$haYR5kRw/eMvbByc92meh.WZAODZuJCwAtZq/ohgV8yIv53sKa2F6', 'voter', `card_uid`, `id`
FROM `voters`;

-- ---------------------------------------------------
-- SEED DATA: VOTES (Suara Masuk)
-- ---------------------------------------------------
INSERT INTO `votes` (`id`, `voter_id`, `candidate_id`, `ip_address`, `voted_at`) VALUES
(1, 1, 1, '127.0.0.1', '2026-09-24 08:10:00'),
(2, 2, 2, '127.0.0.1', '2026-09-24 08:15:00'),
(3, 3, 1, '127.0.0.1', '2026-09-24 08:22:00'),
(4, 4, 3, '127.0.0.1', '2026-09-24 08:30:00'),
(5, 5, 2, '127.0.0.1', '2026-09-24 08:35:00'),
(6, 6, 2, '127.0.0.1', '2026-09-24 08:41:00'),
(7, 7, 1, '127.0.0.1', '2026-09-24 08:49:00'),
(8, 8, 3, '127.0.0.1', '2026-09-24 08:55:00');
