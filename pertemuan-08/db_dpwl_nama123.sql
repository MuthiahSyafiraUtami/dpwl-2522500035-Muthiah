-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Nov 05, 2026 at 08:03 AM
-- Server version: 8.0.30
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_dpwl_nama123`
--

-- --------------------------------------------------------

--
-- Table structure for table `t_admin`
--

CREATE TABLE `t_admin` (
  `username` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `password` char(60) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `status_akun` enum('aktif','nonaktif') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci NOT NULL DEFAULT 'nonaktif'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

--
-- Dumping data for table `t_admin`
--

INSERT INTO `t_admin` (`username`, `password`, `status_akun`) VALUES
('admin', '$2y$10$KAeM1j.05vb6eHernfo0T.vVPtnN6SWCrqHuwidS80t5VDcIDFaXK', 'aktif'),
('muthiah', '$2y$10$FD9vwOSrepEbyaZ6TtKxAOT6WJTCerv76yb.BqST.ofL1RhGy2L42', 'aktif');

-- --------------------------------------------------------

--
-- Table structure for table `t_bayar`
--

CREATE TABLE `t_bayar` (
  `kode_bayar` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `tgl_wkt_byr` datetime NOT NULL,
  `ft_byr` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci DEFAULT NULL,
  `mtode_byr` enum('tunai','transfer') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `jns_byr` enum('dp','pelunasan') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci DEFAULT NULL,
  `nominal` mediumint NOT NULL,
  `sttus_byr` enum('pending','valid','invalid') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `tgl_wkt_ver` datetime DEFAULT NULL,
  `kode_sewa` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

--
-- Dumping data for table `t_bayar`
--

INSERT INTO `t_bayar` (`kode_bayar`, `tgl_wkt_byr`, `ft_byr`, `mtode_byr`, `jns_byr`, `nominal`, `sttus_byr`, `tgl_wkt_ver`, `kode_sewa`) VALUES
('PAY/20261102/01', '2026-11-02 17:06:03', NULL, 'transfer', 'dp', 150000, 'pending', NULL, 'INV/20261102/01'),
('PAY/20261102/02', '2026-11-02 17:06:53', NULL, 'transfer', 'dp', 240000, 'pending', NULL, 'INV/20261102/02');

-- --------------------------------------------------------

--
-- Table structure for table `t_denda`
--

CREATE TABLE `t_denda` (
  `kode_denda` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `telat_jam` tinyint(1) NOT NULL,
  `tarif_per_jam` mediumint NOT NULL,
  `kode_kembali` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

--
-- Dumping data for table `t_denda`
--

INSERT INTO `t_denda` (`kode_denda`, `telat_jam`, `tarif_per_jam`, `kode_kembali`) VALUES
('FINE/20260703/1', 1, 50000, 'RET/20260703/01'),
('FINE/20260703/2', 3, 50000, 'RET/20260703/02'),
('FINE/20260703/3', 2, 25000, 'RET/20260702/01'),
('FINE/20260704/1', 3, 0, 'RET/20260704/01');

-- --------------------------------------------------------

--
-- Table structure for table `t_kembali`
--

CREATE TABLE `t_kembali` (
  `kode_kembali` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `tgl_wkt_blk` datetime NOT NULL,
  `stts_blk` enum('normal','terlambat') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci NOT NULL DEFAULT 'normal',
  `ket_blk` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `kode_bayar` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

--
-- Dumping data for table `t_kembali`
--

INSERT INTO `t_kembali` (`kode_kembali`, `tgl_wkt_blk`, `stts_blk`, `ket_blk`, `kode_bayar`) VALUES
('RET/20260702/01', '2026-07-02 21:30:00', 'terlambat', 'rese', 'PAY/20260702/03'),
('RET/20260703/01', '2026-07-03 15:47:00', 'terlambat', 'mobil sedikit kotor', 'PAY/20260703/01'),
('RET/20260703/02', '2026-07-03 23:11:00', 'terlambat', 'telat 3 jam', 'PAY/20260703/02'),
('RET/20260704/01', '2026-07-04 09:46:00', 'terlambat', 'bensin tidak diisi full', 'PAY/20260704/02'),
('RET/20260706/01', '2026-07-06 14:10:00', 'normal', '', 'PAY/20260706/01');

-- --------------------------------------------------------

--
-- Table structure for table `t_mobil`
--

CREATE TABLE `t_mobil` (
  `no_plat` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `nm_mobil` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `nkursi` tinyint(1) NOT NULL,
  `nbagasi` tinyint(1) NOT NULL,
  `jns_mobil` enum('SUV','MPV','City Car') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci DEFAULT NULL,
  `transmisi` enum('AT','MT') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci DEFAULT NULL,
  `thn_buat` year NOT NULL,
  `ft_depan` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci DEFAULT NULL,
  `ft_blkg` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci DEFAULT NULL,
  `ft_interior` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci DEFAULT NULL,
  `hrg_hari` mediumint NOT NULL,
  `cttn_unit` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `status_unit` enum('tersedia','disewa','tidaktersedia') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci NOT NULL DEFAULT 'tersedia'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

--
-- Dumping data for table `t_mobil`
--

INSERT INTO `t_mobil` (`no_plat`, `nm_mobil`, `nkursi`, `nbagasi`, `jns_mobil`, `transmisi`, `thn_buat`, `ft_depan`, `ft_blkg`, `ft_interior`, `hrg_hari`, `cttn_unit`, `status_unit`) VALUES
('B 1173 HFF', 'Toyota Kijang Innova Reborn 2.4 G Diesel', 7, 2, 'MPV', 'AT', 2025, 'ft_depan_20261027090505_8e62fc8405fcd871.png', 'ft_blkg_20261027090505_d761b0067387bdf8.png', 'ft_interior_20261027090505_759349563882e882.png', 700000, 'Toyota Kijang Innova Reborn 2.4 G Diesel tahun 2025 merupakan kendaraan kategori MPV berkapasitas 7 penumpang yang dilengkapi transmisi otomatis dan mesin diesel 2.4 liter. Kendaraan ini menawarkan kabin yang luas, kenyamanan berkendara yang baik, serta cocok digunakan untuk perjalanan keluarga, wisata, maupun perjalanan dinas.', 'tersedia'),
('B 1583 RKE', 'Honda Brio 1.2 RS CVT CKD', 5, 2, 'City Car', 'AT', 2023, 'ft_depan_20261027063012_0e47476e20159118.png', 'ft_blkg_20261027063012_9bd00a3ab1b06785.png', 'ft_interior_20261027063012_f1956936eca7a642.png', 400000, 'Honda Brio 1.2 RS CVT CKD tahun 2023 merupakan kendaraan kategori City Car dengan kapasitas 5 penumpang yang dilengkapi transmisi otomatis CVT dan mesin bensin 1.2 liter. Kendaraan ini memiliki desain kompak, konsumsi bahan bakar yang efisien, serta cocok digunakan untuk kebutuhan transportasi harian maupun perjalanan dalam kota.', 'tersedia'),
('B 4 LIP', 'Toyota Kijang Innova Reborn 2.4 V Diesel', 7, 2, 'MPV', 'AT', 2020, 'ft_depan_20261027093845_e8500e85a67fa06a.png', 'ft_blkg_20261027093845_b9082fd8fbcfac23.png', 'ft_interior_20261027093845_aa651513975b360e.png', 650000, 'Toyota Kijang Innova Reborn 2.4 V Diesel tahun 2020 merupakan kendaraan kategori MPV berkapasitas 7 penumpang yang dilengkapi transmisi otomatis dan mesin diesel 2.4 liter. Kendaraan ini menawarkan kabin yang luas, kenyamanan berkendara yang baik, serta cocok digunakan untuk perjalanan keluarga, wisata, maupun perjalanan dinas.', 'tersedia'),
('BN 1020 AC', 'Honda Brio 1.2 RS CVT', 5, 2, 'City Car', 'AT', 2021, 'ft_depan_20261027061155_1e6b503e9617fcbb.png', 'ft_blkg_20261027061155_95849be55ca8d939.png', 'ft_interior_20261027061155_a77aafb2ee307f0e.png', 370000, 'Honda Brio 1.2 RS CVT tahun 2021 merupakan kendaraan kategori City Car dengan kapasitas 5 penumpang yang dilengkapi transmisi otomatis CVT dan mesin bensin 1.2 liter. Kendaraan ini memiliki desain kompak, konsumsi bahan bakar yang efisien, serta cocok digunakan untuk kebutuhan transportasi harian maupun perjalanan dalam kota.', 'tersedia'),
('BN 1058 AN', 'Toyota Kijang Innova Reborn 2.0 G', 7, 2, 'MPV', 'AT', 2020, 'ft_depan_20261027074255_6c4d087aace7d72f.png', 'ft_blkg_20261027074255_9b537fff147be262.png', 'ft_interior_20261027074255_5802c6710f2ed86b.png', 550000, 'Toyota Kijang Innova Reborn 2.0 G tahun 2020 merupakan kendaraan kategori MPV berkapasitas 7 penumpang yang dilengkapi transmisi otomatis dan mesin bensin 2.0 liter. Kendaraan ini menawarkan kabin yang luas, kenyamanan berkendara yang baik, serta cocok digunakan untuk perjalanan keluarga, wisata, maupun perjalanan dinas.', 'tersedia'),
('BN 1060 LZQ', 'Toyota Kijang Innova Reborn 2.4 G Diesel', 7, 2, 'MPV', 'AT', 2025, 'ft_depan_20261027090548_d797e4fc4ab47e8e.png', 'ft_blkg_20261027090548_cd53dc6fab3e695e.png', 'ft_interior_20261027090548_7d517b47d8dc70f7.png', 700000, 'Toyota Kijang Innova Reborn 2.4 G Diesel tahun 2025 merupakan kendaraan kategori MPV berkapasitas 7 penumpang yang dilengkapi transmisi otomatis dan mesin diesel 2.4 liter. Kendaraan ini menawarkan kabin yang luas, kenyamanan berkendara yang baik, serta cocok digunakan untuk perjalanan keluarga, wisata, maupun perjalanan dinas.', 'tersedia'),
('BN 1070 VKT', 'Toyota Kijang Innova Reborn 2.4 G Diesel', 7, 2, 'MPV', 'AT', 2025, 'ft_depan_20261027090621_09c4053b5e255792.png', 'ft_blkg_20261027090621_c1d8c1b1b98bdf63.png', 'ft_interior_20261027090621_4227369675a96a94.png', 700000, 'Toyota Kijang Innova Reborn 2.4 G Diesel tahun 2025 merupakan kendaraan kategori MPV berkapasitas 7 penumpang yang dilengkapi transmisi otomatis dan mesin diesel 2.4 liter. Kendaraan ini menawarkan kabin yang luas, kenyamanan berkendara yang baik, serta cocok digunakan untuk perjalanan keluarga, wisata, maupun perjalanan dinas.', 'tersedia'),
('BN 1078 AU', 'Toyota Kijang Innova Reborn 2.4 G Diesel', 7, 2, 'MPV', 'AT', 2023, 'ft_depan_20261027092239_683f6338a335749e.png', 'ft_blkg_20261027092239_fe1b9fd7b5a068e9.png', 'ft_interior_20261027092239_171908632885bfed.png', 680000, 'Toyota Kijang Innova Reborn 2.4 G Diesel tahun 2023 merupakan kendaraan kategori MPV berkapasitas 7 penumpang yang dilengkapi transmisi otomatis dan mesin diesel 2.4 liter. Kendaraan ini menawarkan kabin yang luas, kenyamanan berkendara yang baik, serta cocok digunakan untuk perjalanan keluarga, wisata, maupun perjalanan dinas.', 'tersedia'),
('BN 1142 PJ', 'Toyota Kijang Innova Reborn 2.0 V', 7, 2, 'MPV', 'AT', 2021, 'ft_depan_20261027083529_5ab1d863c2c1e8cd.png', 'ft_blkg_20261027083529_872d01e816bc2203.png', 'ft_interior_20261027083529_c5d920d3de51b41b.png', 600000, 'Toyota Kijang Innova Reborn 2.0 V tahun 2021 merupakan kendaraan kategori MPV berkapasitas 7 penumpang yang dilengkapi transmisi otomatis dan mesin bensin 2.0 liter. Kendaraan ini menawarkan kabin yang luas, kenyamanan berkendara yang baik, serta cocok digunakan untuk perjalanan keluarga, wisata, maupun perjalanan dinas.', 'tersedia'),
('BN 1169 TE', 'Honda Brio 1.2 RS CVT', 5, 2, 'City Car', 'AT', 2025, 'ft_depan_20261027062436_c5706129984b7a12.png', 'ft_blkg_20261027062436_34812587b71f17ef.png', 'ft_interior_20261027062436_00a1dc209c1a5418.png', 450000, 'Honda Brio 1.2 RS CVT tahun 2025 merupakan kendaraan kategori City Car dengan kapasitas 5 penumpang yang dilengkapi transmisi otomatis CVT dan mesin bensin 1.2 liter. Kendaraan ini memiliki desain kompak, konsumsi bahan bakar yang efisien, serta cocok digunakan untuk kebutuhan transportasi harian maupun perjalanan dalam kota.', 'tersedia'),
('BN 1194 AB', 'Honda BR-V 1.5 CVT (All New Honda BR-V)', 7, 2, 'SUV', 'AT', 2022, 'ft_depan_20261024093923_1a151e159280c10e.png', 'ft_blkg_20261024093923_c6e9537756447125.png', 'ft_interior_20261024095609_13707717ad7ee888.png', 500000, 'Honda BR-V 1.5 CVT tahun 2022 merupakan kendaraan kategori SUV Crossover berkapasitas 7 penumpang yang dilengkapi transmisi otomatis CVT dan mesin bensin 1.5 liter. Kendaraan ini menawarkan kabin yang luas, posisi berkendara yang nyaman, serta ground clearance yang tinggi sehingga cocok digunakan untuk perjalanan keluarga, wisata, maupun perjalanan dinas.', 'tersedia'),
('BN 1362 QG', 'Toyota Kijang Innova Reborn 2.0 V', 7, 2, 'MPV', 'AT', 2022, 'ft_depan_20261027084232_e3b7d887168fb03c.png', 'ft_blkg_20261027084232_70e5ee0544124161.png', 'ft_interior_20261027084232_2cfbedad940afd8d.jpg', 620000, 'Toyota Kijang Innova Reborn 2.0 V tahun 2022 merupakan kendaraan kategori MPV berkapasitas 7 penumpang yang dilengkapi transmisi otomatis dan mesin bensin 2.0 liter. Kendaraan ini menawarkan kabin yang luas, kenyamanan berkendara yang baik, serta cocok digunakan untuk perjalanan keluarga, wisata, maupun perjalanan dinas.', 'tersedia'),
('BN 1460 AD', 'Honda Brio 1.2 Satya E CVT', 5, 2, 'City Car', 'AT', 2023, 'ft_depan_20261024171533_ba83702ce09183d7.png', 'ft_blkg_20261024171533_47681ce63082da84.png', 'ft_interior_20261024171533_4c9af6d77f0fe142.png', 380000, 'Honda Brio 1.2 Satya E CVT tahun 2023 merupakan kendaraan kategori City Car dengan kapasitas 5 penumpang yang dilengkapi transmisi otomatis CVT dan mesin bensin 1.2 liter. Kendaraan ini memiliki desain kompak, konsumsi bahan bakar yang efisien, serta cocok digunakan untuk kebutuhan transportasi harian maupun perjalanan dalam kota.', 'tersedia'),
('BN 1467 AV', 'Toyota Kijang Innova Reborn 2.0 G', 7, 2, 'MPV', 'AT', 2020, 'ft_depan_20261027074334_7e2479029f17387d.png', 'ft_blkg_20261027074334_e9ed9fd47c36d35e.png', 'ft_interior_20261027074334_21ac551004dcd924.png', 550000, 'Toyota Kijang Innova Reborn 2.0 G tahun 2020 merupakan kendaraan kategori MPV berkapasitas 7 penumpang yang dilengkapi transmisi otomatis dan mesin bensin 2.0 liter. Kendaraan ini menawarkan kabin yang luas, kenyamanan berkendara yang baik, serta cocok digunakan untuk perjalanan keluarga, wisata, maupun perjalanan dinas.', 'tersedia'),
('BN 1470 AA', 'Toyota Kijang Innova Reborn 2.0 G', 7, 2, 'MPV', 'AT', 2022, 'ft_depan_20261027080442_0a0e225352125ed6.png', 'ft_blkg_20261027080442_f24eba463a82f47f.png', 'ft_interior_20261027080442_f4e8d04b9e1f6ae7.png', 580000, 'Toyota Kijang Innova Reborn 2.0 G tahun 2022 merupakan kendaraan kategori MPV berkapasitas 7 penumpang yang dilengkapi transmisi otomatis dan mesin bensin 2.0 liter. Kendaraan ini menawarkan kabin yang luas, kenyamanan berkendara yang baik, serta cocok digunakan untuk perjalanan keluarga, wisata, maupun perjalanan dinas.', 'tersedia'),
('BN 1570 AC', 'Honda Brio 1.2 RS CVT', 5, 2, 'City Car', 'AT', 2024, 'ft_depan_20261027062345_cadf16d38d53104d.png', 'ft_blkg_20261027062345_4aba5f2fb6db3a67.png', 'ft_interior_20261027062345_28ec1b5a1cec6ca5.png', 420000, 'Honda Brio 1.2 RS CVT tahun 2024 merupakan kendaraan kategori City Car dengan kapasitas 5 penumpang yang dilengkapi transmisi otomatis CVT dan mesin bensin 1.2 liter. Kendaraan ini memiliki desain kompak, konsumsi bahan bakar yang efisien, serta cocok digunakan untuk kebutuhan transportasi harian maupun perjalanan dalam kota.', 'tersedia'),
('BN 1639 AA', 'Honda Brio 1.2 Satya E CVT', 5, 2, 'City Car', 'AT', 2020, 'ft_depan_20261027063214_a98d5075721924a6.png', 'ft_blkg_20261027063214_401f709e4c5099a5.png', 'ft_interior_20261027063214_e57c04e62cdbb77d.png', 350000, 'Honda Brio 1.2 Satya E CVT tahun 2020 merupakan kendaraan kategori City Car dengan kapasitas 5 penumpang yang dilengkapi transmisi otomatis CVT dan mesin bensin 1.2 liter. Kendaraan ini memiliki desain kompak, konsumsi bahan bakar yang efisien, serta cocok digunakan untuk kebutuhan transportasi harian maupun perjalanan dalam kota.', 'tersedia'),
('BN 1663 PJ', 'Honda Brio 1.2 E MT', 5, 2, 'City Car', 'MT', 2020, 'ft_depan_20261027055953_1040ee8e0b0636e0.png', 'ft_blkg_20261027055953_0a62caaafb3a7c98.png', 'ft_interior_20261027055953_75731d72ae825976.png', 300000, 'Honda Brio 1.2 E MT tahun 2020 merupakan kendaraan kategori City Car dengan kapasitas 5 penumpang yang dilengkapi transmisi manual dan mesin bensin 1.2 liter. Kendaraan ini memiliki desain kompak, konsumsi bahan bakar yang efisien, serta cocok digunakan untuk kebutuhan transportasi harian maupun perjalanan dalam kota.', 'tersedia'),
('BN 1721 PI', 'Toyota Kijang Innova Reborn 2.0 G', 7, 2, 'MPV', 'AT', 2020, 'ft_depan_20261027074423_231d7eff2879afd6.png', 'ft_blkg_20261027074423_c4ecfa29e3011003.png', 'ft_interior_20261027074423_c1b725caf35775b1.png', 550000, 'Toyota Kijang Innova Reborn 2.0 G tahun 2020 merupakan kendaraan kategori MPV berkapasitas 7 penumpang yang dilengkapi transmisi otomatis dan mesin bensin 2.0 liter. Kendaraan ini menawarkan kabin yang luas, kenyamanan berkendara yang baik, serta cocok digunakan untuk perjalanan keluarga, wisata, maupun perjalanan dinas.', 'tersedia'),
('BN 1744 NZM', 'Toyota Kijang Innova Reborn 2.4 V Diesel', 7, 2, 'MPV', 'AT', 2025, 'ft_depan_20261027094537_a4dff1358015e63d.png', 'ft_blkg_20261027094537_dc8edf6393e4c5ad.png', 'ft_interior_20261027094537_f891ca36dfed8430.png', 750000, 'Toyota Kijang Innova Reborn 2.4 V Diesel tahun 2025 merupakan kendaraan kategori MPV berkapasitas 7 penumpang yang dilengkapi transmisi otomatis dan mesin diesel 2.4 liter. Kendaraan ini menawarkan kabin yang luas, kenyamanan berkendara yang baik, serta cocok digunakan untuk perjalanan keluarga, wisata, maupun perjalanan dinas.', 'tersedia'),
('BN 1752 AA', 'Honda Brio 1.2 E CVT', 5, 2, 'City Car', 'AT', 2020, 'ft_depan_20261025080644_a87dc5381fab371f.png', 'ft_blkg_20261025080644_8707dd77eff54ba4.png', 'ft_interior_20261025080644_46e55ff9953eab0e.jpg', 360000, 'Honda Brio 1.2 E CVT tahun 2020 merupakan kendaraan kategori City Car dengan kapasitas 5 penumpang yang dilengkapi transmisi otomatis CVT dan mesin bensin 1.2 liter. Kendaraan ini memiliki desain kompak, konsumsi bahan bakar yang efisien, serta cocok digunakan untuk kebutuhan transportasi harian maupun perjalanan dalam kota.', 'tersedia'),
('BN 1755 AA', 'Honda Brio 1.2 Satya S CVT', 5, 2, 'City Car', 'AT', 2020, 'ft_depan_20261027064755_3a2c4642100d7890.png', 'ft_blkg_20261027064755_2bd09c8fed1c0537.png', 'ft_interior_20261027064755_d3171f996f0e8833.png', 340000, 'Honda Brio 1.2 Satya S CVT tahun 2020 merupakan kendaraan kategori City Car dengan kapasitas 5 penumpang yang dilengkapi transmisi otomatis CVT dan mesin bensin 1.2 liter. Kendaraan ini memiliki desain kompak, konsumsi bahan bakar yang efisien, serta cocok digunakan untuk kebutuhan transportasi harian maupun perjalanan dalam kota.', 'tersedia'),
('BN 1759 PJ', 'Toyota Kijang Innova 2.0 V', 7, 2, 'MPV', 'AT', 2021, 'ft_depan_20261025063937_afc0d6e2fa895bbb.png', 'ft_blkg_20261025063937_9d3051bb32532dca.png', 'ft_interior_20261025062621_8b356fd6116917f7.png', 600000, 'Toyota Kijang Innova 2.0 V A/T TGN tahun 2021 merupakan kendaraan kategori MPV berkapasitas 7 penumpang yang dilengkapi transmisi otomatis dan mesin bensin 2.0 liter. Kendaraan ini menawarkan kabin yang luas, kenyamanan berkendara yang baik, serta cocok digunakan untuk perjalanan keluarga, wisata, maupun perjalanan dinas.', 'tersedia'),
('BN 1760 QF', 'Toyota Kijang Innova Reborn 2.0 V', 7, 2, 'MPV', 'AT', 2025, 'ft_depan_20261027084756_990845290a1fe3f7.png', 'ft_blkg_20261027084756_41fda6b36f78ea2c.png', 'ft_interior_20261027084756_097e50f6aea23008.jpg', 650000, 'Toyota Kijang Innova Reborn 2.0 V tahun 2025 merupakan kendaraan kategori MPV berkapasitas 7 penumpang yang dilengkapi transmisi otomatis dan mesin bensin 2.0 liter. Kendaraan ini menawarkan kabin yang luas, kenyamanan berkendara yang baik, serta cocok digunakan untuk perjalanan keluarga, wisata, maupun perjalanan dinas.', 'tersedia'),
('BN 1798 AB', 'Honda Brio 1.2 RS MT', 5, 2, 'City Car', 'MT', 2023, 'ft_depan_20261027062855_b93cc114b349eba0.png', 'ft_blkg_20261027062855_1b276eb360330295.png', 'ft_interior_20261027062855_f7b5637253794ca0.png', 350000, 'Honda Brio 1.2 RS MT tahun 2023 merupakan kendaraan kategori City Car dengan kapasitas 5 penumpang yang dilengkapi transmisi manual dan mesin bensin 1.2 liter. Kendaraan ini memiliki desain kompak, konsumsi bahan bakar yang efisien, serta cocok digunakan untuk kebutuhan transportasi harian maupun perjalanan dalam kota.', 'tersedia'),
('BN 1847 PJ', 'Toyota Avanza Facelift', 7, 2, 'MPV', 'AT', 2021, 'ft_depan_20261025062906_f1ef29bdbb54b0f0.png', 'ft_blkg_20261025062906_fe07356957040ed5.png', 'ft_interior_20261025062906_2d3fc9d9ed087e6d.png', 500000, 'Toyota Avanza Facelift merupakan kendaraan kategori MPV dengan kapasitas 7 penumpang yang dirancang untuk memberikan kenyamanan dan efisiensi dalam berbagai kebutuhan perjalanan. Kendaraan ini memiliki kabin yang luas, konsumsi bahan bakar yang efisien, serta cocok digunakan untuk perjalanan keluarga, wisata, maupun perjalanan dinas.', 'tersedia'),
('BN 1888 XY', 'Honda Brio 1.2 E MT', 5, 2, 'City Car', 'MT', 2022, 'ft_depan_20261025082449_c57e9e157f5bf5c5.png', 'ft_blkg_20261025082449_615c7c83c1699f64.png', 'ft_interior_20261025082449_6453868b5d574673.png', 330000, 'Honda Brio 1.2 E MT tahun 2022 merupakan kendaraan kategori City Car dengan kapasitas 5 penumpang yang dilengkapi transmisi manual dan mesin bensin 1.2 liter. Kendaraan ini memiliki desain kompak, konsumsi bahan bakar yang efisien, serta cocok digunakan untuk kebutuhan transportasi harian maupun perjalanan dalam kota.', 'tersedia'),
('BN 1895 PI', 'Toyota Kijang Innova Reborn 2.0 V', 7, 2, 'MPV', 'AT', 2020, 'ft_depan_20261027084141_36462e5931910421.png', 'ft_blkg_20261027084141_23fb58437262bf51.png', 'ft_interior_20261027084142_ed83914ac786ef1d.jpg', 580000, 'Toyota Kijang Innova Reborn 2.0 V tahun 2020 merupakan kendaraan kategori MPV berkapasitas 7 penumpang yang dilengkapi transmisi otomatis dan mesin bensin 2.0 liter. Kendaraan ini menawarkan kabin yang luas, kenyamanan berkendara yang baik, serta cocok digunakan untuk perjalanan keluarga, wisata, maupun perjalanan dinas.', 'tersedia'),
('BN 1911 AB', 'Honda Brio Satya 1.2 E CVT CKD', 5, 2, 'City Car', 'AT', 2023, 'ft_depan_20261024172323_b3f58b28c71309c2.png', 'ft_blkg_20261024172323_f505a5fc19f88c00.png', 'ft_interior_20261024172323_8d70be9bba1039b0.png', 400000, 'Honda Brio Satya 1.2 E CVT CKD tahun 2023 merupakan kendaraan kategori City Car dengan kapasitas 5 penumpang yang dilengkapi transmisi otomatis CVT dan mesin bensin 1.2 liter. Kendaraan ini memiliki desain kompak, konsumsi bahan bakar yang efisien, serta cocok digunakan untuk kebutuhan transportasi harian maupun perjalanan dalam kota.', 'tersedia'),
('BN 1926 AP', 'Honda Brio 1.2 RS CVT', 5, 2, 'City Car', 'AT', 2022, 'ft_depan_20261027061341_c610c651d3481190.png', 'ft_blkg_20261027061341_8de2c223297a6dac.png', 'ft_interior_20261027061341_275ff079976e3057.png', 380000, 'Honda Brio 1.2 RS CVT tahun 2022 merupakan kendaraan kategori City Car dengan kapasitas 5 penumpang yang dilengkapi transmisi otomatis CVT dan mesin bensin 1.2 liter. Kendaraan ini memiliki desain kompak, konsumsi bahan bakar yang efisien, serta cocok digunakan untuk kebutuhan transportasi harian maupun perjalanan dalam kota.', 'tersedia'),
('BN 1999 ZZ', 'Honda Brio 1.2 RS CVT', 5, 2, 'City Car', 'AT', 2024, 'ft_depan_20261027062407_409acaab9327f346.png', 'ft_blkg_20261027062407_884c4f9d8c22a289.png', 'ft_interior_20261027062407_290e6d13ddc35117.png', 420000, 'Honda Brio 1.2 RS CVT tahun 2024 merupakan kendaraan kategori City Car dengan kapasitas 5 penumpang yang dilengkapi transmisi otomatis CVT dan mesin bensin 1.2 liter. Kendaraan ini memiliki desain kompak, konsumsi bahan bakar yang efisien, serta cocok digunakan untuk kebutuhan transportasi harian maupun perjalanan dalam kota.', 'tersedia'),
('BN 2000 AA', 'Toyota Kijang Innova Reborn 2.0 V', 7, 2, 'MPV', 'AT', 2022, 'ft_depan_20261027084313_5706027f5bce8133.png', 'ft_blkg_20261027084313_b992b27672fa05a6.png', 'ft_interior_20261027084313_93266f8f343a110c.jpg', 620000, 'Toyota Kijang Innova Reborn 2.0 V tahun 2022 merupakan kendaraan kategori MPV berkapasitas 7 penumpang yang dilengkapi transmisi otomatis dan mesin bensin 2.0 liter. Kendaraan ini menawarkan kabin yang luas, kenyamanan berkendara yang baik, serta cocok digunakan untuk perjalanan keluarga, wisata, maupun perjalanan dinas.', 'tersedia'),
('BN 2111 BB', 'Toyota Kijang Innova Reborn 2.4 V Diesel', 7, 2, 'MPV', 'AT', 2023, 'ft_depan_20261027093941_90f3415cd63cb71d.png', 'ft_blkg_20261027093941_d08c07c9ed85ee48.png', 'ft_interior_20261027093941_1af8659a31d38a18.png', 720000, 'Toyota Kijang Innova Reborn 2.4 V Diesel tahun 2023 merupakan kendaraan kategori MPV berkapasitas 7 penumpang yang dilengkapi transmisi otomatis dan mesin diesel 2.4 liter. Kendaraan ini menawarkan kabin yang luas, kenyamanan berkendara yang baik, serta cocok digunakan untuk perjalanan keluarga, wisata, maupun perjalanan dinas.', 'tersedia'),
('BN 2222 CC', 'Honda Brio 1.2 Satya S MT', 5, 2, 'City Car', 'MT', 2021, 'ft_depan_20261027071220_0eec20e483fe4560.png', 'ft_blkg_20261027071220_8270980185a31d78.png', 'ft_interior_20261027071220_942166d17756de4c.png', 310000, 'Honda Brio 1.2 Satya S MT tahun 2021 merupakan kendaraan kategori City Car dengan kapasitas 5 penumpang yang dilengkapi transmisi manual dan mesin bensin 1.2 liter. Kendaraan ini memiliki desain kompak, konsumsi bahan bakar yang efisien, serta cocok digunakan untuk kebutuhan transportasi harian maupun perjalanan dalam kota.', 'tersedia'),
('BN 2285 BRH', 'Toyota Kijang Innova Reborn 2.4 V Diesel', 7, 2, 'MPV', 'AT', 2026, 'ft_depan_20261027094726_b2ec6ed68bbd8a1d.png', 'ft_blkg_20261027094726_7e9b3a270a5ae2b3.png', 'ft_interior_20261027094726_4d5703968080fbec.png', 800000, 'Toyota Kijang Innova Reborn 2.4 V Diesel tahun 2026 merupakan kendaraan kategori MPV berkapasitas 7 penumpang yang dilengkapi transmisi otomatis dan mesin diesel 2.4 liter. Kendaraan ini menawarkan kabin yang luas, kenyamanan berkendara yang baik, serta cocok digunakan untuk perjalanan keluarga, wisata, maupun perjalanan dinas.', 'tersedia'),
('BN 2333 DD', 'Honda Brio 1.2 Satya E CVT', 5, 2, 'City Car', 'AT', 2025, 'ft_depan_20261027064250_04a9cbca2ab37436.png', 'ft_blkg_20261027064250_ed079c1b2ed0afa9.png', 'ft_interior_20261027064250_7c6c5db39737c88a.png', 400000, 'Honda Brio 1.2 Satya E CVT tahun 2025 merupakan kendaraan kategori City Car dengan kapasitas 5 penumpang yang dilengkapi transmisi otomatis CVT dan mesin bensin 1.2 liter. Kendaraan ini memiliki desain kompak, konsumsi bahan bakar yang efisien, serta cocok digunakan untuk kebutuhan transportasi harian maupun perjalanan dalam kota.', 'tersedia'),
('BN 2444 EE', 'Toyota Kijang Innova Reborn 2.0 G', 7, 2, 'MPV', 'AT', 2024, 'ft_depan_20261027080709_5b51bd1045acd7ce.png', 'ft_blkg_20261027080709_eec7f6e957060693.png', 'ft_interior_20261027080709_cbdaba08e9bfd7bd.png', 600000, 'Toyota Kijang Innova Reborn 2.0 G tahun 2024 merupakan kendaraan kategori MPV berkapasitas 7 penumpang yang dilengkapi transmisi otomatis dan mesin bensin 2.0 liter. Kendaraan ini menawarkan kabin yang luas, kenyamanan berkendara yang baik, serta cocok digunakan untuk perjalanan keluarga, wisata, maupun perjalanan dinas.', 'tersedia'),
('BN 2555 FF', 'Honda Brio 1.2 RS CVT', 5, 2, 'City Car', 'AT', 2022, 'ft_depan_20261027061404_81a955046f9c87e0.png', 'ft_blkg_20261027061404_a2d7894819246ffb.png', 'ft_interior_20261027061404_d4b64f0841a59f05.png', 380000, 'Honda Brio 1.2 RS CVT tahun 2022 merupakan kendaraan kategori City Car dengan kapasitas 5 penumpang yang dilengkapi transmisi otomatis CVT dan mesin bensin 1.2 liter. Kendaraan ini memiliki desain kompak, konsumsi bahan bakar yang efisien, serta cocok digunakan untuk kebutuhan transportasi harian maupun perjalanan dalam kota.', 'tersedia'),
('BN 2625 SQQ', 'Toyota Kijang Innova Reborn 2.4 V Diesel', 7, 2, 'MPV', 'AT', 2025, 'ft_depan_20261027094635_4d808902a02798cf.png', 'ft_blkg_20261027094635_532c60a8362c1ef8.png', 'ft_interior_20261027094635_1f43a57df8205a5e.png', 750000, 'Toyota Kijang Innova Reborn 2.4 V Diesel tahun 2025 merupakan kendaraan kategori MPV berkapasitas 7 penumpang yang dilengkapi transmisi otomatis dan mesin diesel 2.4 liter. Kendaraan ini menawarkan kabin yang luas, kenyamanan berkendara yang baik, serta cocok digunakan untuk perjalanan keluarga, wisata, maupun perjalanan dinas.', 'tersedia'),
('BN 2666 GG', 'Toyota Kijang Innova Reborn 2.4 G Diesel', 7, 2, 'MPV', 'AT', 2021, 'ft_depan_20261027091303_72d56dadc35fc9ed.png', 'ft_blkg_20261027091303_bad72b71cb3accbf.png', 'ft_interior_20261027091303_4ea902a7e7b48154.png', 600000, 'Toyota Kijang Innova Reborn 2.4 G Diesel tahun 2021 merupakan kendaraan kategori MPV berkapasitas 7 penumpang yang dilengkapi transmisi otomatis dan mesin diesel 2.4 liter. Kendaraan ini menawarkan kabin yang luas, kenyamanan berkendara yang baik, serta cocok digunakan untuk perjalanan keluarga, wisata, maupun perjalanan dinas.', 'tersedia'),
('BN 2736 PKU', 'Toyota Kijang Innova Reborn 2.4 V Diesel', 7, 2, 'MPV', 'AT', 2025, 'ft_depan_20261027094808_b6d4508c3b6028a5.png', 'ft_blkg_20261027094808_91419e5aca15ab1c.png', 'ft_interior_20261027094808_d1afd206aa6a9b52.png', 750000, 'Toyota Kijang Innova Reborn 2.4 V Diesel tahun 2025 merupakan kendaraan kategori MPV berkapasitas 7 penumpang yang dilengkapi transmisi otomatis dan mesin diesel 2.4 liter. Kendaraan ini menawarkan kabin yang luas, kenyamanan berkendara yang baik, serta cocok digunakan untuk perjalanan keluarga, wisata, maupun perjalanan dinas.', 'tersedia'),
('BN 2786 VQT', 'Toyota Kijang Innova Reborn 2.4 V Diesel', 7, 2, 'MPV', 'AT', 2026, 'ft_depan_20261027094841_b5b833b364e2684e.png', 'ft_blkg_20261027094841_cdf873c71dc09492.png', 'ft_interior_20261027094841_5889ec3b256fd587.png', 800000, 'Toyota Kijang Innova Reborn 2.4 V Diesel tahun 2026 merupakan kendaraan kategori MPV berkapasitas 7 penumpang yang dilengkapi transmisi otomatis dan mesin diesel 2.4 liter. Kendaraan ini menawarkan kabin yang luas, kenyamanan berkendara yang baik, serta cocok digunakan untuk perjalanan keluarga, wisata, maupun perjalanan dinas.', 'tersedia'),
('BN 2814 PN', 'Pajero Sport', 8, 2, 'SUV', 'AT', 2026, 'ft_depan_20261015093642_79cd952434696894.jpg', 'ft_blkg_20261015093642_35c41935b8f24543.jpg', 'ft_interior_20261015093642_2d4ce94b671e3708.jpg', 800000, 'SUV tangguh dengan desain eksterior elegan dan interior yang nyaman. Dilengkapi kabin luas, kapasitas penumpang yang memadai, serta performa yang cocok untuk perjalanan dalam kota maupun luar kota. Kendaraan dirawat secara berkala untuk menunjang kenyamanan dan keamanan selama penggunaan.', 'disewa');

-- --------------------------------------------------------

--
-- Table structure for table `t_penyewa`
--

CREATE TABLE `t_penyewa` (
  `user_plg` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `sandi` char(60) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `nik` char(16) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `nm_lngkp` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `no_hp` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `almt_lngkp` varchar(300) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `ft_ktp` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci DEFAULT NULL,
  `ft_sim_a` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

--
-- Dumping data for table `t_penyewa`
--

INSERT INTO `t_penyewa` (`user_plg`, `sandi`, `nik`, `nm_lngkp`, `no_hp`, `almt_lngkp`, `ft_ktp`, `ft_sim_a`) VALUES
('aisyah', '$2y$10$jBHIse2MUp2R5CRlorg08ufjRkHLzFVcjnDhD.GRc2YBLz1agDqeW', '1971922019928288', 'Aisyah Nurul Putri', '087766761234', 'Jl. Raden Said Abdullah Kota Sungailiat', NULL, NULL),
('andi', '$2y$10$abcdefghijklmnopqrstuvwxyz0123456789ABCDEFGHIJKLM2', '1971030303030003', 'Andi Prasetyo', '082156789012', 'Jl. Merdeka RT 003 RW 003 Kel. Bukit Intan Kec. Bukit Intan Kota Pangkalpinang Provinsi Kepulauan Bangka Belitung', NULL, NULL),
('budi', '$2y$10$abcdefghijklmnopqrstuvwxyz0123456789ABCDEFGHIJKLMN', '1971010101010001', 'Budi Santoso', '081234567890', 'Jl. Depati Hamzah RT 001 RW 001 Kel. Air Itam Kec. Bukit Intan Kota Pangkalpinang Provinsi Kepulauan Bangka Belitung', NULL, NULL),
('dewi', '$2y$10$abcdefghijklmnopqrstuvwxyz0123456789ABCDEFGHIJKLM3', '1971040404040004', 'Dewi Lestari', '082267890123', 'Jl. Ahmad Yani RT 004 RW 004 Kel. Gabek Kec. Gabek Kota Pangkalpinang Provinsi Kepulauan Bangka Belitung', NULL, NULL),
('eko', '$2y$10$abcdefghijklmnopqrstuvwxyz0123456789ABCDEFGHIJKLM4', '1971050505050005', 'Eko Widodo', '085378901234', 'Jl. Sudirman RT 005 RW 005 Kel. Girimaya Kec. Girimaya Kota Pangkalpinang Provinsi Kepulauan Bangka Belitung', NULL, NULL),
('gema', '$2y$10$yLYgFo9VhVu0L/g2pvvO5ujSpT0tO2dt28URyVD5MAVz8LYe2R9gq', '1971041210910012', 'Gema Saputra', '08126672888', 'Jl. Sriwijaya RT 004 RW 002 Kel. Asam Kec. Rangkui Kota Pangkalpinang Provinsi Kepulauan Bangka Belitung', 'ft_ktp_1782316776_6a3bfee8711f0.jpg', 'ft_sim_a_1782316776_6a3bfee871739.jpg'),
('irhamdani', '$2y$10$zc96yRwpTlsfvig7zA9nReftZAn1NFIi7o.WymyAfhIv1I8rVErc.', '1971012009940001', 'Irhamdani', '081378772655', 'Jl. Depati Hamzah RT 009 RW 003 Kel. Air Itam Kec. Bukit Intan Kota Pangkalpinang Provinsi Kepulauan Bangka Belitung', 'ft_ktp_1782632700_6a40d0fc4ee6c.webp', NULL),
('joko', '$2y$10$abcdefghijklmnopqrstuvwxyz0123456789ABCDEFGHIJKLM8', '1971090909090009', 'Joko Susilo', '085812345678', 'Jl. Veteran RT 009 RW 009 Kel. Pasar Padi Kec. Taman Sari Kota Pangkalpinang Provinsi Kepulauan Bangka Belitung', NULL, NULL),
('lillguurlll_', '$2y$10$UVUQbDf72zq4UJlP9eJvbeEwdXWxIfdoHdCRUWmCSyGYBM31LBkkK', '1902015405070002', 'Muthiah Syafira Utami', '08176052606', 'Jl. Bicong, Desa Air Merbau, Tanjungpandan, Belitung', NULL, NULL),
('lintang', '$2y$10$abcdefghijklmnopqrstuvwxyz0123456789ABCDEFGHIJKLM9', '1971101010100010', 'Lintang Pradipta', '085923456789', 'Jl. Bangka RT 010 RW 010 Kel. Selindung Kec. Gerunggang Kota Pangkalpinang Provinsi Kepulauan Bangka Belitung', NULL, NULL),
('maya', '$2y$10$abcdefghijklmnopqrstuvwxyz0123456789ABCDEFGHIJKLM7', '1971080808080008', 'Maya Sari', '085701234567', 'Jl. Imam Bonjol RT 008 RW 008 Kel. Opas Indah Kec. Gerunggang Kota Pangkalpinang Provinsi Kepulauan Bangka Belitung', NULL, NULL),
('ratna', '$2y$10$NfvB6cLtk4ho9zvHGRw2VOQHiCvyhThcmzMkdgVUiTOU6qNO1b4du', '1012929292929292', 'Ratna Dewi', '08191919', 'Jl. Belinyu Bangka', NULL, NULL),
('rini', '$2y$10$abcdefghijklmnopqrstuvwxyz0123456789ABCDEFGHIJKLM5', '1971060606060006', 'Rini Wulandari', '085489012345', 'Jl. Pahlawan RT 006 RW 006 Kel. Kampung Melayu Kec. Rangkui Kota Pangkalpinang Provinsi Kepulauan Bangka Belitung', NULL, NULL),
('siti', '$2y$10$abcdefghijklmnopqrstuvwxyz0123456789ABCDEFGHIJKLM1', '1971020202020002', 'Siti Aminah', '081345678901', 'Jl. Sriwijaya RT 002 RW 002 Kel. Asam Kec. Rangkui Kota Pangkalpinang Provinsi Kepulauan Bangka Belitung', NULL, NULL),
('sukamieayam_', '$2y$10$6HXhfnuvFj1gCcykfWRGfuLw/8.gyZSlFVGvEDNzN0wTbkkbykV32', '1902015405070002', 'Muthiah Syafira Utami', '+628176052606', 'Jl. Bicong, Desa Air Merbau, Kec. Tanjungpandan, Belitung', 'ft_ktp_20261024090437_2fe8caf7b11b300e.jpg', NULL),
('tono', '$2y$10$abcdefghijklmnopqrstuvwxyz0123456789ABCDEFGHIJKLM6', '1971070707070007', 'Tono Supriyadi', '085690123456', 'Jl. Diponegoro RT 007 RW 007 Kel. Ketapang Kec. Rangkui Kota Pangkalpinang Provinsi Kepulauan Bangka Belitung', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `t_pilih`
--

CREATE TABLE `t_pilih` (
  `kode_sewa` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `no_plat` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `hrg_sewa` mediumint NOT NULL,
  `n_hari` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

--
-- Dumping data for table `t_pilih`
--

INSERT INTO `t_pilih` (`kode_sewa`, `no_plat`, `hrg_sewa`, `n_hari`) VALUES
('INV/20260702/01', 'B 1583 RKE', 400000, 1),
('INV/20260702/01', 'BN 1460 AD', 500000, 1),
('INV/20260702/02', 'B 1173 HFF', 700000, 2),
('INV/20260703/01', 'BN 1194 AB', 500000, 1),
('INV/20260704/01', 'BN 1752 AA', 360000, 1),
('INV/20260704/02', 'BN 1194 AB', 500000, 1),
('INV/20260705/01', 'BN 1194 AB', 500000, 1),
('INV/20260705/02', 'BN 1194 AB', 500000, 1),
('INV/20260712/01', 'B 1583 RKE', 400000, 1),
('INV/20260712/02', 'B 4 LIP', 650000, 1),
('INV/20261102/01', 'BN 1194 AB', 500000, 1),
('INV/20261102/02', 'BN 1194 AB', 500000, 1),
('INV/20261102/02', 'BN 1663 PJ', 300000, 1),
('INV/20261102/03', 'BN 1194 AB', 500000, 1),
('INV/20261102/04', 'BN 1194 AB', 500000, 1),
('INV/20261104/01', 'BN 1194 AB', 500000, 1);

-- --------------------------------------------------------

--
-- Table structure for table `t_sewa`
--

CREATE TABLE `t_sewa` (
  `kode_sewa` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `tgl_mulai` date NOT NULL,
  `tgl_selesai` date NOT NULL,
  `wkt_ambil` time NOT NULL,
  `status_sewa` enum('diajukan','disetujui','ditolak','aktif','selesai','batal','keranjang') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci DEFAULT 'keranjang',
  `user_plg` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

--
-- Dumping data for table `t_sewa`
--

INSERT INTO `t_sewa` (`kode_sewa`, `tgl_mulai`, `tgl_selesai`, `wkt_ambil`, `status_sewa`, `user_plg`) VALUES
('INV/20261102/01', '2026-11-02', '2026-11-03', '09:21:26', 'diajukan', 'sukamieayam_'),
('INV/20261102/02', '2026-11-02', '2026-11-03', '10:06:23', 'diajukan', 'sukamieayam_'),
('INV/20261104/01', '2026-11-04', '2026-11-05', '07:10:25', 'keranjang', 'sukamieayam_');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `t_admin`
--
ALTER TABLE `t_admin`
  ADD PRIMARY KEY (`username`);

--
-- Indexes for table `t_bayar`
--
ALTER TABLE `t_bayar`
  ADD PRIMARY KEY (`kode_bayar`);

--
-- Indexes for table `t_denda`
--
ALTER TABLE `t_denda`
  ADD PRIMARY KEY (`kode_denda`);

--
-- Indexes for table `t_kembali`
--
ALTER TABLE `t_kembali`
  ADD PRIMARY KEY (`kode_kembali`);

--
-- Indexes for table `t_mobil`
--
ALTER TABLE `t_mobil`
  ADD PRIMARY KEY (`no_plat`);

--
-- Indexes for table `t_penyewa`
--
ALTER TABLE `t_penyewa`
  ADD PRIMARY KEY (`user_plg`);

--
-- Indexes for table `t_pilih`
--
ALTER TABLE `t_pilih`
  ADD PRIMARY KEY (`kode_sewa`,`no_plat`);

--
-- Indexes for table `t_sewa`
--
ALTER TABLE `t_sewa`
  ADD PRIMARY KEY (`kode_sewa`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
