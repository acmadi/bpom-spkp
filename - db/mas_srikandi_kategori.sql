-- phpMyAdmin SQL Dump
-- version 4.4.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: 03 Mei 2016 pada 06.50
-- Versi Server: 5.6.26
-- PHP Version: 5.6.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `bpom_spkp_2016`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `mas_srikandi_kategori`
--

CREATE TABLE IF NOT EXISTS `mas_srikandi_kategori` (
  `id_kategori` int(10) NOT NULL,
  `id_kategori_parent` int(10) NOT NULL,
  `id_subdit` int(10) NOT NULL,
  `nama` varchar(300) NOT NULL
) ENGINE=MyISAM AUTO_INCREMENT=26 DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `mas_srikandi_kategori`
--

INSERT INTO `mas_srikandi_kategori` (`id_kategori`, `id_kategori_parent`, `id_subdit`, `nama`) VALUES
(1, 0, 2, 'KLB'),
(2, 0, 2, 'Progress Kerjasama lintas Sektor Dalam dan Luar Ne'),
(3, 2, 2, 'INRASFF'),
(4, 0, 2, 'Progress Program Prioritas Pengawasan Obat dan Mak'),
(5, 4, 2, 'INARAC'),
(6, 4, 2, 'INRASFF'),
(7, 0, 2, 'Risk Profile dari Food Borne Disease ?'),
(8, 0, 2, 'Risk Analysis dari Food Borne Disease ?'),
(9, 0, 4, 'Progress Penyusunan Revisi Peraturan Tentang Penga'),
(10, 9, 4, 'Monitoring dan Evaluasi Implementasi Perka Badan P'),
(11, 0, 4, 'Progress Kerjasama lintas Sektor Dalam dan Luar Ne'),
(12, 11, 4, 'RADPG'),
(13, 0, 4, 'Progres Program Prioritas Pengawasa Obat dan Makan'),
(14, 13, 4, 'GKPD'),
(15, 13, 4, 'Kompetensi Tenaga PKP dan DFI'),
(16, 13, 4, 'Food Safety Clearinghouse'),
(17, 13, 4, 'Pendampingan UMKM Pangan dalam Penerapan CPPOB dan'),
(18, 0, 3, 'Progres Kerjasama Lintas Sektor Dalam dan Luar Neg'),
(19, 18, 3, 'JPKP'),
(20, 0, 3, 'Progres Program Prioritas Pengawasan Obat dan Maka'),
(21, 20, 3, 'KP Tingkat Menengah'),
(22, 20, 3, 'FKPS');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `mas_srikandi_kategori`
--
ALTER TABLE `mas_srikandi_kategori`
  ADD PRIMARY KEY (`id_kategori`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `mas_srikandi_kategori`
--
ALTER TABLE `mas_srikandi_kategori`
  MODIFY `id_kategori` int(10) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=26;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
