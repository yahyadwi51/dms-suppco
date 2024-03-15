-- phpMyAdmin SQL Dump
-- version 4.4.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Nov 26, 2020 at 02:55 AM
-- Server version: 5.6.26
-- PHP Version: 5.6.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `reminder_dok`
--

-- --------------------------------------------------------

--
-- Table structure for table `gap_demografi_t_k`
--

CREATE TABLE IF NOT EXISTS `gap_demografi_t_k` (
  `id_demografi_t_k` int(11) NOT NULL,
  `id_jenis_t_n` int(11) NOT NULL,
  `sd_l` int(11) NOT NULL,
  `sd_p` int(11) NOT NULL,
  `smp_l` int(11) NOT NULL,
  `smp_p` int(11) NOT NULL,
  `sma_l` int(11) NOT NULL,
  `sma_p` int(11) NOT NULL,
  `sarjana_l` int(11) NOT NULL,
  `sarjana_p` int(11) NOT NULL,
  `s2_l` int(11) NOT NULL,
  `s2_p` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `gap_demografi_t_k`
--

INSERT INTO `gap_demografi_t_k` (`id_demografi_t_k`, `id_jenis_t_n`, `sd_l`, `sd_p`, `smp_l`, `smp_p`, `sma_l`, `sma_p`, `sarjana_l`, `sarjana_p`, `s2_l`, `s2_p`) VALUES
(1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1),
(2, 2, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1),
(3, 3, 7, 5, 7, 5, 7, 5, 7, 5, 7, 5),
(4, 4, 1, 6, 6, 6, 7, 7, 7, 7, 7, 5),
(5, 5, 7, 7, 5, 44, 3, 3, 3, 3, 35, 5),
(6, 6, 9, 2, 2, 6, 5, 6, 5, 4, 45, 5);

-- --------------------------------------------------------

--
-- Table structure for table `gap_histori_demografi`
--

CREATE TABLE IF NOT EXISTS `gap_histori_demografi` (
  `id_histori_demograf` int(11) NOT NULL,
  `id_demografi_t_k` int(11) NOT NULL,
  `sd_l` int(11) NOT NULL,
  `sd_p` int(11) NOT NULL,
  `smp_l` int(11) NOT NULL,
  `smp_p` int(11) NOT NULL,
  `sma_l` int(11) NOT NULL,
  `sma_p` int(11) NOT NULL,
  `sarjana_l` int(11) NOT NULL,
  `sarjana_p` int(11) NOT NULL,
  `s2_l` int(11) NOT NULL,
  `s2_p` int(11) NOT NULL,
  `tanggal` date NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `gap_histori_demografi`
--

INSERT INTO `gap_histori_demografi` (`id_histori_demograf`, `id_demografi_t_k`, `sd_l`, `sd_p`, `smp_l`, `smp_p`, `sma_l`, `sma_p`, `sarjana_l`, `sarjana_p`, `s2_l`, `s2_p`, `tanggal`) VALUES
(1, 3, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, '0000-00-00'),
(2, 3, 7, 5, 7, 5, 7, 5, 7, 5, 7, 5, '0000-00-00'),
(3, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, '0000-00-00'),
(4, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, '2020-11-07');

-- --------------------------------------------------------

--
-- Table structure for table `gap_histori_infrastruktur_pendukung`
--

CREATE TABLE IF NOT EXISTS `gap_histori_infrastruktur_pendukung` (
  `id_histori_infra_pen` int(11) NOT NULL,
  `id_infra_pen` int(11) NOT NULL,
  `tanggal_update` date NOT NULL,
  `histori_kondisi_saat_ini` text NOT NULL,
  `histori_upload_dokumen` text NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `gap_histori_infrastruktur_pendukung`
--

INSERT INTO `gap_histori_infrastruktur_pendukung` (`id_histori_infra_pen`, `id_infra_pen`, `tanggal_update`, `histori_kondisi_saat_ini`, `histori_upload_dokumen`) VALUES
(1, 1, '2002-11-23', 'rrrrrrr', 'Laporan_Dokumen (3).xls,Report Kecelakaan_internal.xlsx'),
(2, 1, '2020-11-09', 'aaaa', 'dd14705e-92a6-4951-8371-3441e9abc5d6.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `gap_histori_legal_ijin`
--

CREATE TABLE IF NOT EXISTS `gap_histori_legal_ijin` (
  `id_histori_li` int(11) NOT NULL,
  `id_legal_ijin` int(11) NOT NULL,
  `tanggal_update` date NOT NULL,
  `histori_kondisi_saat_ini` text NOT NULL,
  `histori_upload_dokumen` text NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `gap_histori_legal_ijin`
--

INSERT INTO `gap_histori_legal_ijin` (`id_histori_li`, `id_legal_ijin`, `tanggal_update`, `histori_kondisi_saat_ini`, `histori_upload_dokumen`) VALUES
(1, 2, '2020-11-20', 'aaa', 'Rekap_INO_TI.pdf'),
(2, 1, '2020-11-20', 'ccc', 'Laporan_Dokumen (3).xls'),
(3, 1, '2020-11-20', 'bbb', 'Rekap_INO_TI.pdf'),
(4, 5, '2020-11-28', 'Kurang Aman', 'Rekap_Agenda_18-11-2020_081838.pdf'),
(5, 1, '2003-11-20', '', 'Laporan_Dokumen (3).xls'),
(6, 1, '2020-11-20', 'asd', 'Laporan_Dokumen (3).xls'),
(7, 1, '2003-11-20', 'assss', 'Report Kecelakaan_internal.xlsx'),
(8, 1, '2020-11-20', 'sadas', 'Laporan_Dokumen (3).xls'),
(9, 1, '1970-01-01', 'aa', 'Laporan_Dokumen (3).xls'),
(10, 1, '2003-11-20', 'tttt', 'Laporan_Dokumen (3).xls,Report Kecelakaan_internal.xlsx'),
(11, 1, '1970-01-01', 'aaa', 'Laporan_Dokumen (3).xls,uploads_Laporan_Dokumen (4).xls,uploads_Laporan_Dokumen (4).xls'),
(12, 1, '2020-11-20', 'qqqqq1', 'Laporan_Dokumen (3).xls'),
(13, 1, '2003-11-20', 'asssa', 'Report Kecelakaan_internal.xlsx,Laporan_Dokumen (3).xls'),
(14, 5, '2003-11-20', 'aaa', 'KSI Legalitas dan Perijinan (3).xls');

-- --------------------------------------------------------

--
-- Table structure for table `gap_histori_pengelolaan_kebun`
--

CREATE TABLE IF NOT EXISTS `gap_histori_pengelolaan_kebun` (
  `id_histori_peng_keb` int(11) NOT NULL,
  `id_peng_keb` int(11) NOT NULL,
  `tanggal_update` date NOT NULL,
  `histori_kondisi_saat_ini` text NOT NULL,
  `histori_upload_dokumen` text NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `gap_histori_pengelolaan_kebun`
--

INSERT INTO `gap_histori_pengelolaan_kebun` (`id_histori_peng_keb`, `id_peng_keb`, `tanggal_update`, `histori_kondisi_saat_ini`, `histori_upload_dokumen`) VALUES
(1, 1, '2003-11-20', 'b', 'Rekap INO TI.pdf'),
(2, 1, '2003-11-20', 'b', 'Rekap_INO_TI2.pdf'),
(3, 1, '2020-11-20', 'cccc', 'Manual Penggunaan Aplikasi IT Support - User.pdf'),
(4, 1, '2020-11-20', 'a', 'Rekap_INO_TI5.pdf'),
(5, 1, '2020-11-20', 'a', 'Rekap_INO_TI6.pdf'),
(6, 1, '2020-11-03', 'aaa', 'aa'),
(7, 1, '2003-11-20', 'zzzz', 'Report Kecelakaan_internal.xlsx,Laporan_Dokumen (3).xls'),
(8, 1, '2003-11-20', 'zxzxzxzx', 'Laporan_Dokumen (3).xls,uploads_Laporan_Dokumen (4).xls');

-- --------------------------------------------------------

--
-- Table structure for table `gap_histori_perkara`
--

CREATE TABLE IF NOT EXISTS `gap_histori_perkara` (
  `id_histori_perkara` int(11) NOT NULL,
  `id_perkara` int(11) NOT NULL,
  `tanggal_update` date NOT NULL,
  `histori_kondisi_saat_ini` text NOT NULL,
  `histori_upload_dokumen` text NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `gap_histori_perkara`
--

INSERT INTO `gap_histori_perkara` (`id_histori_perkara`, `id_perkara`, `tanggal_update`, `histori_kondisi_saat_ini`, `histori_upload_dokumen`) VALUES
(1, 1, '2003-11-14', 'aaaa', 'Sosial dan Lingkungan (1).xls'),
(2, 1, '2020-11-20', 'aaaaaa', 'Sosial_dan_Lingkungan_(1)1.xls'),
(3, 2, '2020-11-19', 'Aman', ''),
(4, 1, '2003-11-20', 'aaaa', 'Report Kecelakaan_internal.xlsx,Laporan_Dokumen (3).xls,uploads_Laporan_Dokumen (4).xls');

-- --------------------------------------------------------

--
-- Table structure for table `gap_histori_prmslhan_hub_industrial`
--

CREATE TABLE IF NOT EXISTS `gap_histori_prmslhan_hub_industrial` (
  `id_histori_permasalahan` int(11) NOT NULL,
  `id_permasalahan` int(11) NOT NULL,
  `tanggal_update` date NOT NULL,
  `histori_kondisi_saat_ini` text NOT NULL,
  `histori_upload_dokumen` text NOT NULL,
  `tab` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `gap_histori_prmslhan_hub_industrial`
--

INSERT INTO `gap_histori_prmslhan_hub_industrial` (`id_histori_permasalahan`, `id_permasalahan`, `tanggal_update`, `histori_kondisi_saat_ini`, `histori_upload_dokumen`, `tab`) VALUES
(1, 1, '2020-11-07', 'b', 'Report Kecelakaan_internal.xlsx', 1),
(2, 2, '2020-11-05', 'nnn', 'Perhitungan Beban Kerja Bagian BAGIAN PENGADAAN DAN UMUM.xlsx', 2),
(3, 1, '2019-11-20', 'dfdfd', 'Perhitungan_Beban_Kerja_Bagian_BAGIAN_PENGADAAN_DAN_UMUM5.xlsx', 2),
(4, 2, '2003-11-20', 'fff', 'FORM_PENGISIAN_PTPN___AJI.xlsx', 1),
(5, 2, '2020-11-20', 'asdasd', 'Pengelolaan_Kebun.xls', 2),
(6, 1, '2020-11-25', 'Aman', 'Legalitas_dan_Perijinan_(2).xls', 1),
(7, 1, '2020-11-21', 'SUdah sidang', 'Report Kecelakaan_internal.xlsx,Laporan_Dokumen (3).xls', 2),
(8, 1, '2020-11-20', 'asasasasasasasasas', 'Report Kecelakaan_internal.xlsx,Laporan_Dokumen (3).xls', 2),
(9, 1, '2020-11-20', 'sda', 'Laporan_Dokumen (3).xls,Report Kecelakaan_internal.xlsx', 1),
(10, 1, '2020-11-20', 'sdas', 'Report Kecelakaan_internal.xlsx,Laporan_Dokumen (3).xls', 0);

-- --------------------------------------------------------

--
-- Table structure for table `gap_histori_sos_ling`
--

CREATE TABLE IF NOT EXISTS `gap_histori_sos_ling` (
  `id_histori_sos_ling` int(11) NOT NULL,
  `id_sos_lik` int(11) NOT NULL,
  `tanggal_update` date NOT NULL,
  `histori_kondisi_saat_ini` text NOT NULL,
  `histori_upload_dokumen` text NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `gap_histori_sos_ling`
--

INSERT INTO `gap_histori_sos_ling` (`id_histori_sos_ling`, `id_sos_lik`, `tanggal_update`, `histori_kondisi_saat_ini`, `histori_upload_dokumen`) VALUES
(1, 1, '2003-11-21', 'c', 'Report Kecelakaan_internal.xlsx,Laporan_Dokumen (3).xls'),
(2, 1, '2003-11-20', 'aa', 'Permasalahan_Hubungan_Industrial_(1).pdf'),
(3, 1, '2003-11-20', 'd', 'Report Kecelakaan_internal.xlsx,Laporan_Dokumen (3).xls');

-- --------------------------------------------------------

--
-- Table structure for table `gap_infrastruktur_pendukung`
--

CREATE TABLE IF NOT EXISTS `gap_infrastruktur_pendukung` (
  `id_infra_pen` int(11) NOT NULL,
  `jenis_infrastruktur` int(11) NOT NULL,
  `no_hgu` varchar(225) NOT NULL,
  `nama_infra` text NOT NULL,
  `jumlah` int(11) NOT NULL,
  `kondisi_saat_ini` text NOT NULL,
  `keterangan` text NOT NULL,
  `upload_dokumen` text NOT NULL,
  `status` int(11) NOT NULL,
  `luas_tanah` varchar(225) NOT NULL,
  `luas_bangunan` varchar(225) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `gap_infrastruktur_pendukung`
--

INSERT INTO `gap_infrastruktur_pendukung` (`id_infra_pen`, `jenis_infrastruktur`, `no_hgu`, `nama_infra`, `jumlah`, `kondisi_saat_ini`, `keterangan`, `upload_dokumen`, `status`, `luas_tanah`, `luas_bangunan`) VALUES
(1, 1, '111111', 'Infrastruktur', 12, 'avv', 'avv', 'Rekap_INO_TI9.pdf', 0, '33', '11'),
(3, 2, '2342342', 'Fasilitas umum', 2, '', '', '', 0, '', ''),
(4, 3, '2342342', 'Fasilitas Sosial', 0, '', '', '', 0, '', '');

-- --------------------------------------------------------

--
-- Table structure for table `gap_jenis_kepatuhan`
--

CREATE TABLE IF NOT EXISTS `gap_jenis_kepatuhan` (
  `id_jen_kep` int(11) NOT NULL,
  `nama_jen_kep` text NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `gap_jenis_kepatuhan`
--

INSERT INTO `gap_jenis_kepatuhan` (`id_jen_kep`, `nama_jen_kep`) VALUES
(1, 'Izin Lokasi'),
(2, 'Izin Usaha Perkebunan'),
(3, 'Izin Lingkungan Amdal'),
(4, 'Izin Lingkungan DPLH'),
(5, 'Izin Lingkungan UKL-UPL'),
(6, 'Izin Tempat Penyimpanan Limbah B3'),
(7, 'Izin Pembuangan Limbah Cair'),
(8, 'Izin Penggunaan Air Permukaan'),
(9, 'Izin Usaha Industri'),
(10, 'Izin Mendirikan Bangunan'),
(11, 'Tanda Daftar Gudang');

-- --------------------------------------------------------

--
-- Table structure for table `gap_kat_pertanahan`
--

CREATE TABLE IF NOT EXISTS `gap_kat_pertanahan` (
  `id_kat_tanah` int(11) NOT NULL,
  `id_pertanahan` int(11) NOT NULL,
  `kat` varchar(255) NOT NULL,
  `luas` int(11) NOT NULL,
  `tanggal_terjadi` date NOT NULL,
  `latitude` varchar(225) NOT NULL,
  `longitude` varchar(225) NOT NULL,
  `subjek` varchar(255) NOT NULL,
  `kerugian` text NOT NULL,
  `komoditi` text NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `gap_kat_pertanahan`
--

INSERT INTO `gap_kat_pertanahan` (`id_kat_tanah`, `id_pertanahan`, `kat`, `luas`, `tanggal_terjadi`, `latitude`, `longitude`, `subjek`, `kerugian`, `komoditi`) VALUES
(1, 1, '2', 11, '0000-00-00', '11', '11', '1', '11', '11'),
(2, 1, '3', 222, '2001-11-20', '222', '222', '1', '222', '222'),
(3, 1, '4', 0, '0000-00-00', '', '', '- Pilih Subjek/Pelaku/Instansi Terkait -', '', ''),
(4, 1, '5', 0, '0000-00-00', '', '', '- Pilih Subjek/Pelaku/Instansi Terkait -', '', ''),
(7, 2, '1', 11, '2002-11-20', '11', '11', '', '', '22'),
(8, 2, '2', 22, '2020-11-10', '22', '22', '1', '33', '22'),
(9, 2, '3', 4, '2002-11-20', '4', '4', '1', '4', '4'),
(10, 2, '4', 2, '2020-11-17', '2', '2', '1', '777', '777'),
(11, 2, '5', 222, '2001-11-20', '999', '999', '1', '777', '22'),
(12, 3, '2', 12312, '1231-01-01', '12312', '1233123', '1', '1231', '12312'),
(13, 3, '2', 123, '2002-11-20', '1231', '123', '1', '1231', '123123'),
(14, 3, '3', 123, '2002-11-20', '213123', '12312', '1', '1312', '213123'),
(15, 3, '5', 12312, '2002-11-20', '123123', '12321312', '1', '12312', '12312');

-- --------------------------------------------------------

--
-- Table structure for table `gap_legal_ijin`
--

CREATE TABLE IF NOT EXISTS `gap_legal_ijin` (
  `id_legal_ijin` int(11) NOT NULL,
  `no_hgu` varchar(225) NOT NULL,
  `no_ktun` varchar(225) NOT NULL,
  `tanggal_terbit` date NOT NULL,
  `tanggal_berakhir` date NOT NULL,
  `kondisi_saat_ini` text NOT NULL,
  `keterangan` text NOT NULL,
  `jenis_kepatuhan` int(11) NOT NULL,
  `upload_dokumen` text NOT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `gap_legal_ijin`
--

INSERT INTO `gap_legal_ijin` (`id_legal_ijin`, `no_hgu`, `no_ktun`, `tanggal_terbit`, `tanggal_berakhir`, `kondisi_saat_ini`, `keterangan`, `jenis_kepatuhan`, `upload_dokumen`, `status`) VALUES
(1, '2342342', '11111', '2020-12-31', '2020-12-30', 'b', 'b', 2, 'map_(5).kml', 0),
(2, '111111', '11111', '2011-02-02', '2020-11-10', 'b', 'b', 1, '', 0),
(3, '111111', '11111', '2011-02-02', '2020-11-10', 'b', 'b', 1, 'map_(5)2.kml', 0),
(4, '111111', '11111', '2011-02-02', '2020-11-10', 'b', 'b', 1, 'map_(5)3.kml', 1),
(5, '2342342', '22222222', '2020-10-11', '2020-11-20', 'Aman', 'Aman terkendali', 6, '32_M_9871_XI_2020_-_Undangan_Rapat21.pdf', 0);

-- --------------------------------------------------------

--
-- Table structure for table `gap_master_hgu`
--

CREATE TABLE IF NOT EXISTS `gap_master_hgu` (
  `id_hgu` int(11) NOT NULL,
  `nomor_hgu` varchar(255) NOT NULL,
  `lokasi_kebun` text NOT NULL,
  `koordinat` text NOT NULL,
  `upload_kml` varchar(255) NOT NULL,
  `keterangan` text NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `gap_master_hgu`
--

INSERT INTO `gap_master_hgu` (`id_hgu`, `nomor_hgu`, `lokasi_kebun`, `koordinat`, `upload_kml`, `keterangan`) VALUES
(1, '2342342', 'Tes', 'TES', 'TES', 'Penjelasan tes');

-- --------------------------------------------------------

--
-- Table structure for table `gap_master_jenis_tenaga_kerja`
--

CREATE TABLE IF NOT EXISTS `gap_master_jenis_tenaga_kerja` (
  `id_jenis_t_n` int(11) NOT NULL,
  `nama_jenis_t_n` varchar(225) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `gap_master_jenis_tenaga_kerja`
--

INSERT INTO `gap_master_jenis_tenaga_kerja` (`id_jenis_t_n`, `nama_jenis_t_n`) VALUES
(1, 'keryawan tetap keb'),
(2, 'PKWT keb'),
(3, 'Harian Lepas keb'),
(4, 'Karyawan Tetap pab'),
(5, 'PKWT pab'),
(6, 'Harian Lepas keb');

-- --------------------------------------------------------

--
-- Table structure for table `gap_master_kerjasama`
--

CREATE TABLE IF NOT EXISTS `gap_master_kerjasama` (
  `id_kerjasama` int(11) NOT NULL,
  `nama` varchar(225) NOT NULL,
  `keterangan` text NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `gap_master_kerjasama`
--

INSERT INTO `gap_master_kerjasama` (`id_kerjasama`, `nama`, `keterangan`) VALUES
(1, 'KSU', ''),
(2, 'KSO', ''),
(3, 'Sewa', '');

-- --------------------------------------------------------

--
-- Table structure for table `gap_master_lsm`
--

CREATE TABLE IF NOT EXISTS `gap_master_lsm` (
  `id_lsm` int(11) NOT NULL,
  `nama_lsm` varchar(225) NOT NULL,
  `lokasi_lsm` varchar(225) NOT NULL,
  `pic` varchar(255) NOT NULL,
  `alamat` text NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `gap_master_lsm`
--

INSERT INTO `gap_master_lsm` (`id_lsm`, `nama_lsm`, `lokasi_lsm`, `pic`, `alamat`) VALUES
(1, 'LSM Kuda Putih', 'Jember', 'Glantangan', 'Jl Jember');

-- --------------------------------------------------------

--
-- Table structure for table `gap_master_objek_kerjasama`
--

CREATE TABLE IF NOT EXISTS `gap_master_objek_kerjasama` (
  `id_objek_kerjasama` int(11) NOT NULL,
  `nama_objek_kerjasama` text NOT NULL,
  `keterangan` text NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `gap_master_objek_kerjasama`
--

INSERT INTO `gap_master_objek_kerjasama` (`id_objek_kerjasama`, `nama_objek_kerjasama`, `keterangan`) VALUES
(1, 'Komoditi', '');

-- --------------------------------------------------------

--
-- Table structure for table `gap_non_perkara`
--

CREATE TABLE IF NOT EXISTS `gap_non_perkara` (
  `id_non_pekara` int(11) NOT NULL,
  `no_hgu` int(11) NOT NULL,
  `subjek` varchar(225) NOT NULL,
  `waktu` date NOT NULL,
  `lokasi` varchar(225) NOT NULL,
  `kondisi_saat_ini` text NOT NULL,
  `upaya` text NOT NULL,
  `keterangan` text NOT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `gap_pengelolaan_kebun`
--

CREATE TABLE IF NOT EXISTS `gap_pengelolaan_kebun` (
  `id_olah_keb` int(11) NOT NULL,
  `no_perjanjian` varchar(225) NOT NULL,
  `no_hgu` int(11) NOT NULL,
  `kerjasama` text NOT NULL,
  `jenis_kerjasama` int(11) NOT NULL,
  `mitra` text NOT NULL,
  `luas` varchar(225) NOT NULL,
  `tk_long` text NOT NULL,
  `tk_lat` text NOT NULL,
  `nilai_kompensasi` text NOT NULL,
  `objek_kerjasama` int(11) NOT NULL,
  `tanggal_perjanjian` date NOT NULL,
  `tanggal_akhir_perjanjian` date NOT NULL,
  `jangka_waktu` int(11) NOT NULL,
  `kondisi_saat_ini` text NOT NULL,
  `keterangan` text NOT NULL,
  `upload_dokumen` text NOT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `gap_pengelolaan_kebun`
--

INSERT INTO `gap_pengelolaan_kebun` (`id_olah_keb`, `no_perjanjian`, `no_hgu`, `kerjasama`, `jenis_kerjasama`, `mitra`, `luas`, `tk_long`, `tk_lat`, `nilai_kompensasi`, `objek_kerjasama`, `tanggal_perjanjian`, `tanggal_akhir_perjanjian`, `jangka_waktu`, `kondisi_saat_ini`, `keterangan`, `upload_dokumen`, `status`) VALUES
(1, 'd', 2342342, 'd', 1, 'd', 'd', 'd', 'd', 'd', 1, '2020-11-13', '2020-11-10', 0, 'd', 'd', 'Rekap_INO_TI1.pdf', 0),
(2, 'd', 2342342, 'd', 1, 'd', 'd', 'd', 'd', 'd', 1, '2013-11-21', '2010-11-20', 0, 'd', 'd', '', 0),
(3, 'd', 2342342, 'd', 1, 'd', 'd', 'd', 'd', 'd', 1, '2020-11-13', '2010-11-30', 1, 'd', 'd', '', 0),
(4, 'd', 2342342, 'd', 2, 'd', 'd', 'd', 'd', 'd', 0, '2020-11-13', '2010-11-20', 2, 'd', 'd', '', 0);

-- --------------------------------------------------------

--
-- Table structure for table `gap_perkara`
--

CREATE TABLE IF NOT EXISTS `gap_perkara` (
  `id_perkara` int(11) NOT NULL,
  `no_hgu` int(11) NOT NULL,
  `subjek` varchar(225) NOT NULL,
  `waktu` date NOT NULL,
  `lokasi` varchar(255) NOT NULL,
  `kondisi_saat_ini` text NOT NULL,
  `upaya` text NOT NULL,
  `keterangan` text NOT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `gap_perkara`
--

INSERT INTO `gap_perkara` (`id_perkara`, `no_hgu`, `subjek`, `waktu`, `lokasi`, `kondisi_saat_ini`, `upaya`, `keterangan`, `status`) VALUES
(1, 1, 'sssd', '2020-11-03', 'a', 'a', 'a', 'a', 0),
(2, 111111, '1111', '2005-01-01', '1111', '1111', '111', '1111', 0);

-- --------------------------------------------------------

--
-- Table structure for table `gap_pertanahan`
--

CREATE TABLE IF NOT EXISTS `gap_pertanahan` (
  `id_pertanahan` int(11) NOT NULL,
  `no_hgu` int(11) NOT NULL,
  `hak_atas_tanah` varchar(225) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `gap_pertanahan`
--

INSERT INTO `gap_pertanahan` (`id_pertanahan`, `no_hgu`, `hak_atas_tanah`) VALUES
(1, 2342342, 'adasd'),
(2, 2342342, 'adasd'),
(3, 2342342, 'rer');

-- --------------------------------------------------------

--
-- Table structure for table `gap_prmslhan_hub_industrial`
--

CREATE TABLE IF NOT EXISTS `gap_prmslhan_hub_industrial` (
  `id_permasalahan` int(11) NOT NULL,
  `subjek` varchar(225) NOT NULL,
  `waktu` date NOT NULL,
  `lokasi` text NOT NULL,
  `kerugian` text NOT NULL,
  `kondisi_saat_ini` text NOT NULL,
  `upaya_penyelesaian` text NOT NULL,
  `keterangan` text NOT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `gap_prmslhan_hub_industrial`
--

INSERT INTO `gap_prmslhan_hub_industrial` (`id_permasalahan`, `subjek`, `waktu`, `lokasi`, `kerugian`, `kondisi_saat_ini`, `upaya_penyelesaian`, `keterangan`, `status`) VALUES
(1, 'b', '2021-02-11', 'b', 'b', 'sdas', 'b', 'b', 1),
(2, 'a', '2030-02-07', 's', 's', 'asdasd', 's', 's', 1);

-- --------------------------------------------------------

--
-- Table structure for table `gap_sosial_lingkungan`
--

CREATE TABLE IF NOT EXISTS `gap_sosial_lingkungan` (
  `id_sos_lik` int(11) NOT NULL,
  `nama_lsm` varchar(225) NOT NULL,
  `lokasi` varchar(225) NOT NULL,
  `tanggal` date NOT NULL,
  `kondisi_saat_ini` text NOT NULL,
  `kondisi_10thn_terakhir` text NOT NULL,
  `keterangan` text NOT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `gap_sosial_lingkungan`
--

INSERT INTO `gap_sosial_lingkungan` (`id_sos_lik`, `nama_lsm`, `lokasi`, `tanggal`, `kondisi_saat_ini`, `kondisi_10thn_terakhir`, `keterangan`, `status`) VALUES
(1, '1', 'bbb', '2002-11-30', 'bbb', 'bbbbb', 'bbbb', 0),
(2, '1', 'a', '2020-11-03', 'a', 'a', 'a', 1),
(3, '- Pilih LSM/Tokoh Masyarakat/Instansi -', 'a', '2020-11-24', 'aa', 'aaa', 'aa', 1),
(4, '1', 'bbb', '2020-11-25', 'a', 'a', 'a', 0);

-- --------------------------------------------------------

--
-- Table structure for table `histori_download_dokumen`
--

CREATE TABLE IF NOT EXISTS `histori_download_dokumen` (
  `id` int(11) NOT NULL,
  `id_dokumen` int(11) NOT NULL,
  `status` varchar(255) NOT NULL,
  `keterangan` text NOT NULL,
  `log` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `tanggal_download` varchar(225) NOT NULL,
  `kode_unik` varchar(225) NOT NULL,
  `peminta` varchar(225) NOT NULL,
  `ip` text NOT NULL,
  `browser` varchar(255) NOT NULL,
  `mac` text NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `histori_download_dokumen`
--

INSERT INTO `histori_download_dokumen` (`id`, `id_dokumen`, `status`, `keterangan`, `log`, `tanggal_download`, `kode_unik`, `peminta`, `ip`, `browser`, `mac`) VALUES
(2, 1, 'Request', 'tes2', '2020-10-19 07:15:27', '', 'JH8juWUQo6pP', 'Banjarsari', '::1', 'Opera', '2C-56-DC-47-CD-32'),
(3, 1, 'Request', 'tes3', '2020-10-19 07:28:20', '', '1Hub7P5LvwnU', 'Banjarsari', '::1', 'Opera', '2C-56-DC-47-CD-32'),
(4, 4, 'Berhasil', 'tes', '2020-11-03 03:06:47', '11/03/2020', 'hjgwrui5kWZA', 'Tanaman', '::1', 'Opera', '18-4F-32-5A-66-EE'),
(5, 4, 'Request', 'Buat Percontohan', '2020-11-04 04:11:00', '', 'wIeCHzY5SQDP', 'Tanaman', '::1', 'Opera', '18-4F-32-5A-66-EE'),
(6, 15, 'Berhasil', 'Untuk Bukti', '2020-11-18 04:26:41', '11/18/2020', '7HzRAr8l6oFZ', 'Hansyah', '::1', 'Opera', '18-4F-32-5A-66-EE'),
(7, 15, 'Berhasil', 'fgd', '2020-11-18 08:21:50', '11/18/2020', 'a7LSYiHgcUVP', 'Hansyah', '::1', 'Opera', '18-4F-32-5A-66-EE');

-- --------------------------------------------------------

--
-- Table structure for table `histori_pembarui_dokumen`
--

CREATE TABLE IF NOT EXISTS `histori_pembarui_dokumen` (
  `id` int(11) NOT NULL,
  `id_dokumen` int(11) NOT NULL,
  `log` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `masa_aktif_awal_lama` date NOT NULL,
  `masa_aktif_akhir_lama` date NOT NULL,
  `upload_dokumen_lama` text NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `histori_pembarui_dokumen`
--

INSERT INTO `histori_pembarui_dokumen` (`id`, `id_dokumen`, `log`, `masa_aktif_awal_lama`, `masa_aktif_akhir_lama`, `upload_dokumen_lama`) VALUES
(1, 5, '2020-11-02 05:27:54', '0000-00-00', '0000-00-00', ''),
(2, 5, '2020-11-02 05:29:56', '0000-00-00', '0000-00-00', ''),
(3, 6, '2020-11-03 02:31:50', '0000-00-00', '0000-00-00', ''),
(4, 5, '2020-11-03 03:14:48', '0000-00-00', '0000-00-00', ''),
(5, 4, '2020-11-03 05:41:49', '2020-11-02', '2021-05-04', 'tes'),
(6, 4, '2020-11-03 06:43:20', '1970-01-01', '1970-01-01', ''),
(7, 4, '2020-11-03 06:44:01', '2020-01-10', '2020-01-16', 'Laporan_Dokumen_(2)2.xls'),
(8, 4, '2020-11-03 06:45:16', '2020-01-17', '2020-01-18', 'Laporan_Download4.pdf'),
(9, 1, '2020-11-04 04:20:40', '2020-11-22', '2020-11-24', '8329_(1).pdf'),
(10, 1, '2020-11-04 04:25:16', '2020-11-12', '2020-11-13', ''),
(11, 4, '2020-11-17 03:42:23', '2020-01-09', '2020-01-10', 'Laporan_Download5.pdf'),
(12, 4, '2020-11-17 03:46:04', '2020-01-09', '2020-01-10', '32_M_9871_XI_2020_-_Undangan_Rapat.pdf'),
(13, 8, '2020-11-17 08:20:25', '2020-11-17', '2020-11-17', '32_M_9871_XI_2020_-_Undangan_Rapat3.pdf'),
(14, 9, '2020-11-18 04:31:14', '2020-11-21', '2020-11-28', '32_M_9871_XI_2020_-_Undangan_Rapat2.pdf'),
(15, 9, '2020-11-23 04:43:32', '2020-12-01', '2020-12-31', 'cetak_dokumen_(1)1.pdf'),
(16, 9, '2020-11-23 04:43:56', '2021-01-04', '2021-01-05', ''),
(17, 9, '2020-11-23 04:45:05', '2021-01-04', '2021-01-05', '');

-- --------------------------------------------------------

--
-- Table structure for table `hkm_dokumen`
--

CREATE TABLE IF NOT EXISTS `hkm_dokumen` (
  `id_dokumen` int(11) NOT NULL,
  `user_upload` int(11) NOT NULL,
  `nama_dokumen` varchar(255) NOT NULL,
  `jenis_dokumen` varchar(20) NOT NULL,
  `pic` varchar(255) NOT NULL,
  `status` varchar(25) NOT NULL,
  `akses_for` varchar(100) NOT NULL,
  `tanggal` varchar(100) NOT NULL,
  `upload_dokumen` varchar(255) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `hkm_dokumen`
--

INSERT INTO `hkm_dokumen` (`id_dokumen`, `user_upload`, `nama_dokumen`, `jenis_dokumen`, `pic`, `status`, `akses_for`, `tanggal`, `upload_dokumen`) VALUES
(1, 1, 'Dokumen Hukum Tanah', '3', 'fajar', 'Dicabut', '2', '03/11/2020', '8329.pdf');

-- --------------------------------------------------------

--
-- Table structure for table `hkm_dokumen_download`
--

CREATE TABLE IF NOT EXISTS `hkm_dokumen_download` (
  `id_download` int(11) NOT NULL,
  `id_dokumen` int(11) NOT NULL,
  `user_download` varchar(255) NOT NULL,
  `browser` varchar(255) NOT NULL,
  `ip` text NOT NULL,
  `mac` text NOT NULL,
  `log` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `hkm_dokumen_download`
--

INSERT INTO `hkm_dokumen_download` (`id_download`, `id_dokumen`, `user_download`, `browser`, `ip`, `mac`, `log`) VALUES
(1, 1, '1', 'Opera', '::1', '2C-56-DC-47-CD-32', '2020-10-19 04:46:53');

-- --------------------------------------------------------

--
-- Table structure for table `hkm_dokumen_proses`
--

CREATE TABLE IF NOT EXISTS `hkm_dokumen_proses` (
  `id_proses` int(11) NOT NULL,
  `id_dokumen` int(11) NOT NULL,
  `upload_dokumen` text NOT NULL,
  `status` varchar(255) NOT NULL,
  `log` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `hkm_master_jenis_dokumen`
--

CREATE TABLE IF NOT EXISTS `hkm_master_jenis_dokumen` (
  `id_jenis_dokumen` int(11) NOT NULL,
  `nama_jenis_dokumen` varchar(255) NOT NULL,
  `status_jenis_dokumen` varchar(255) NOT NULL,
  `keterangan` text NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `hkm_master_jenis_dokumen`
--

INSERT INTO `hkm_master_jenis_dokumen` (`id_jenis_dokumen`, `nama_jenis_dokumen`, `status_jenis_dokumen`, `keterangan`) VALUES
(3, 'Surat Edaran', '', ''),
(4, 'Surat Keputusan', '', ''),
(5, 'Peraturan Direksi', '', ''),
(6, 'Standard Operational Procedure', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `tb_dokumen`
--

CREATE TABLE IF NOT EXISTS `tb_dokumen` (
  `id` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `nama_dokumen` text NOT NULL,
  `bag_or_keb` varchar(255) NOT NULL,
  `jenis_dok` text NOT NULL,
  `masa_aktif_awal` date NOT NULL,
  `masa_aktif_akhir` date NOT NULL,
  `pic` text NOT NULL,
  `akses_for` text NOT NULL,
  `upload_dokumen` varchar(255) NOT NULL,
  `pengingat` int(1) NOT NULL,
  `durasi_tahun` int(11) NOT NULL,
  `durasi_bulan` int(11) NOT NULL,
  `durasi_tgl` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tb_dokumen`
--

INSERT INTO `tb_dokumen` (`id`, `id_user`, `nama_dokumen`, `bag_or_keb`, `jenis_dok`, `masa_aktif_awal`, `masa_aktif_akhir`, `pic`, `akses_for`, `upload_dokumen`, `pengingat`, `durasi_tahun`, `durasi_bulan`, `durasi_tgl`) VALUES
(8, 2, 'Dokumen Tanmana', '4 ', '1', '2020-11-20', '2020-11-21', 'aaaaa', '3', 'Laporan_Dokumen_(1).xls', 1, 0, 3, 0),
(9, 1, 'Dokumen admin', '0', '1', '2021-01-04', '2021-01-05', 'Fajar', '3,4', 'Report_Kecelakaan_internal.xlsx', 1, 0, 3, 0),
(10, 2, 'Dokumen', '4', '1', '2020-11-17', '2020-11-17', 'asdad', '3', '32_M_9871_XI_2020_-_Undangan_Rapat4.pdf', 1, 0, 3, 0),
(11, 3, 'Dokumen Bnjarsari', '31 ', '4', '2020-11-17', '2020-11-17', 'Fajar', '7', '32_M_9871_XI_2020_-_Undangan_Rapat4.pdf', 1, 3, 0, 0),
(12, 2, 'sadasd', '4 ', '1', '2020-11-17', '2020-11-17', 'asdad', '5,7', '', 1, 0, 3, 0),
(13, 3, 'bbbbb', '31 ', '6', '2020-11-17', '2020-11-17', 'Fajar', '0,4,5,6,7,8,9,15,27', '', 1, 0, 0, 0),
(14, 1, 'STNK Mobil Direktur', '12', '1', '2020-11-19', '2020-11-20', 'Fajar', '7', 'cetak_dokumen_(1).pdf', 1, 0, 4, 0),
(15, 1, 'HGU Banjarsari', '31', '4', '2020-11-11', '2020-12-16', 'Sekper', '3', 'Laporan_Dokumen.xls', 1, 3, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `tb_master_bagian`
--

CREATE TABLE IF NOT EXISTS `tb_master_bagian` (
  `id_bagian` int(11) NOT NULL,
  `nama_bagian` text NOT NULL,
  `kode` varchar(225) NOT NULL,
  `keterangan` text NOT NULL,
  `status` varchar(225) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=52 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tb_master_bagian`
--

INSERT INTO `tb_master_bagian` (`id_bagian`, `nama_bagian`, `kode`, `keterangan`, `status`) VALUES
(0, 'Admin', 'admin', 'admin', ''),
(3, 'Sekretaris Perusahaan', '12', '', 'Aktif'),
(4, 'Tanaman', '21', '', 'Aktif'),
(5, 'Satuan Pengawas Intern', '11', '', 'Aktif'),
(6, 'Budidaya Kayu dan Tanaman Semusim', '96', '', 'Aktif'),
(7, 'Teknik & Pengolahan', '22', '', 'Aktif'),
(8, 'Keuangan & Akuntansi', '31', '', 'Aktif'),
(9, 'Akuntansi', '97', '', 'Aktif'),
(10, 'Hukum', '98', '', 'Aktif'),
(11, 'Proyek ERP', '99', '', 'Aktif'),
(12, 'Pengadaan & Umum', '32', '', 'Aktif'),
(13, 'PKBL dan Umum', '95', '', 'Aktif'),
(14, 'Sumber Daya Manusia', '33', '', 'Aktif'),
(15, 'Perencanaan & Sustainabilitiy', '13', '', 'Aktif'),
(16, 'Pemasaran & Optimalisasi Aset', '34', '', 'Aktif'),
(17, 'pabrik', '89', '', 'Aktif'),
(18, 'Gunung Gumitir', 'GGT', '', 'Aktif'),
(19, 'Jatirono', 'JTR', '', 'Aktif'),
(20, 'Kendenglembu', 'KDL', '', 'Aktif'),
(21, 'Kaliselogiri', 'KLG', '', 'Aktif'),
(22, 'Kalikempit', 'KLK', '', 'Aktif'),
(23, 'Kalirejo', 'KLR', '', 'Aktif'),
(24, 'Kalisepanjang', 'KLS', '', 'Aktif'),
(25, 'Kalitelepak', 'KLT', '', 'Aktif'),
(26, 'Malangsari', 'MLS', '', 'Aktif'),
(27, 'Pasewaran', 'PSW', '', 'Aktif'),
(28, 'Sumberjambe', 'SBJ', '', 'Aktif'),
(29, 'Sungailembu', 'SGL', '', 'Aktif'),
(30, 'Blawan', 'BLW', '', 'Aktif'),
(31, 'Banjarsari', 'BSR', '', 'Aktif'),
(32, 'Glantangan', 'GLT', '', 'Aktif'),
(33, 'Kotta Blater', 'KBL', '', 'Aktif'),
(34, 'Kalisat Jampit', 'KLJ', '', 'Aktif'),
(35, 'Kalisanen', 'KLN', '', 'Aktif'),
(36, 'Kayumas', 'KYM', '', 'Aktif'),
(37, 'Mumbul', 'MBL', '', 'Aktif'),
(38, 'Pancur Angkrek', 'PCA', '', 'Aktif'),
(39, 'Renteng', 'REN', '', 'Aktif'),
(40, 'Sumber Tengah', 'SBT', '', 'Aktif'),
(41, 'Silosanen', 'SIL', '', 'Aktif'),
(42, 'Zeelandia', 'ZEEL', '', 'Aktif'),
(43, 'Bangelan', 'BGL', '', 'Aktif'),
(44, 'Bangelan', 'BNT', '', 'Aktif'),
(45, 'Gunung Gambir', 'GGB', '', 'Aktif'),
(46, 'Kalibakar', 'KLB', '', 'Aktif'),
(47, 'Kertowono', 'KNO', '', 'Aktif'),
(48, 'Ngrangkah Pawon', 'NPW', '', 'Aktif'),
(49, 'Pancursari', 'PSR', '', 'Aktif'),
(50, 'Tretes', 'TRS', '', 'Aktif'),
(51, 'Wonosari', 'WRI', '', 'Aktif');

-- --------------------------------------------------------

--
-- Table structure for table `tb_master_jenis_dok`
--

CREATE TABLE IF NOT EXISTS `tb_master_jenis_dok` (
  `id` int(11) NOT NULL,
  `nama_jenis_dokumen` varchar(255) NOT NULL,
  `durasi_tahun` int(11) NOT NULL,
  `durasi_bulan` int(11) DEFAULT NULL,
  `durasi_tgl` int(11) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tb_master_jenis_dok`
--

INSERT INTO `tb_master_jenis_dok` (`id`, `nama_jenis_dokumen`, `durasi_tahun`, `durasi_bulan`, `durasi_tgl`) VALUES
(1, 'STNK', 0, 3, 0),
(4, 'HGU', 3, 0, 0),
(5, 'Perjanjian/MoU/Kontrak/Nota Kesepahaman', 0, 3, 0),
(6, 'Perijinan', 0, 3, 0),
(7, 'Asuransi', 0, 3, 0),
(8, 'HGB', 3, 0, 0),
(9, 'PAS Bandara', 0, 1, 0),
(10, 'Audit Charter', 0, 3, 0),
(11, 'Sertifikasi', 0, 3, 0);

-- --------------------------------------------------------

--
-- Table structure for table `tb_role`
--

CREATE TABLE IF NOT EXISTS `tb_role` (
  `id` int(11) NOT NULL,
  `role` varchar(255) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tb_role`
--

INSERT INTO `tb_role` (`id`, `role`) VALUES
(1, 'admin'),
(2, 'user');

-- --------------------------------------------------------

--
-- Table structure for table `tb_user`
--

CREATE TABLE IF NOT EXISTS `tb_user` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role_id` int(11) NOT NULL,
  `bagian` int(11) NOT NULL,
  `no_telp` varchar(255) NOT NULL,
  `is_active` int(1) NOT NULL,
  `date_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tb_user`
--

INSERT INTO `tb_user` (`id`, `username`, `password`, `role_id`, `bagian`, `no_telp`, `is_active`, `date_created`) VALUES
(1, 'admin', '$2y$10$4Ia1VVi5VtqIOcjnbD5/2Ou3TJRaoARf2oP23YIQuJXjHf8Kk2E8G', 1, 0, '087865018862', 1, '0000-00-00 00:00:00'),
(2, 'Fajar', '$2y$10$TuF3HeuIyEN9K0PnQcOp6.XRnc2NB78OqsCwRB5hrDHIdDY1RQzhu', 2, 4, '087865018862', 1, '2020-11-17 07:24:57'),
(3, 'Hansyah', '$2y$10$3eSsxKv0o2fVupvYImuAKOZID10pFHLcVrAzm1uPKwJK1TM4smjMS', 2, 31, '087865018862', 1, '2020-11-17 07:25:01'),
(4, 'User', '$2y$10$utHm6B03qYkK/WE1fz4m0e3tyouHv9yQdkIUtEhSXf/Y5O.yiX61y', 2, 12, '087865018862', 1, '2020-11-26 01:48:11');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `gap_demografi_t_k`
--
ALTER TABLE `gap_demografi_t_k`
  ADD PRIMARY KEY (`id_demografi_t_k`);

--
-- Indexes for table `gap_histori_demografi`
--
ALTER TABLE `gap_histori_demografi`
  ADD PRIMARY KEY (`id_histori_demograf`);

--
-- Indexes for table `gap_histori_infrastruktur_pendukung`
--
ALTER TABLE `gap_histori_infrastruktur_pendukung`
  ADD PRIMARY KEY (`id_histori_infra_pen`);

--
-- Indexes for table `gap_histori_legal_ijin`
--
ALTER TABLE `gap_histori_legal_ijin`
  ADD PRIMARY KEY (`id_histori_li`);

--
-- Indexes for table `gap_histori_pengelolaan_kebun`
--
ALTER TABLE `gap_histori_pengelolaan_kebun`
  ADD PRIMARY KEY (`id_histori_peng_keb`);

--
-- Indexes for table `gap_histori_perkara`
--
ALTER TABLE `gap_histori_perkara`
  ADD PRIMARY KEY (`id_histori_perkara`);

--
-- Indexes for table `gap_histori_prmslhan_hub_industrial`
--
ALTER TABLE `gap_histori_prmslhan_hub_industrial`
  ADD PRIMARY KEY (`id_histori_permasalahan`);

--
-- Indexes for table `gap_histori_sos_ling`
--
ALTER TABLE `gap_histori_sos_ling`
  ADD PRIMARY KEY (`id_histori_sos_ling`);

--
-- Indexes for table `gap_infrastruktur_pendukung`
--
ALTER TABLE `gap_infrastruktur_pendukung`
  ADD PRIMARY KEY (`id_infra_pen`);

--
-- Indexes for table `gap_jenis_kepatuhan`
--
ALTER TABLE `gap_jenis_kepatuhan`
  ADD PRIMARY KEY (`id_jen_kep`);

--
-- Indexes for table `gap_kat_pertanahan`
--
ALTER TABLE `gap_kat_pertanahan`
  ADD PRIMARY KEY (`id_kat_tanah`);

--
-- Indexes for table `gap_legal_ijin`
--
ALTER TABLE `gap_legal_ijin`
  ADD PRIMARY KEY (`id_legal_ijin`);

--
-- Indexes for table `gap_master_hgu`
--
ALTER TABLE `gap_master_hgu`
  ADD PRIMARY KEY (`id_hgu`);

--
-- Indexes for table `gap_master_jenis_tenaga_kerja`
--
ALTER TABLE `gap_master_jenis_tenaga_kerja`
  ADD PRIMARY KEY (`id_jenis_t_n`);

--
-- Indexes for table `gap_master_kerjasama`
--
ALTER TABLE `gap_master_kerjasama`
  ADD PRIMARY KEY (`id_kerjasama`);

--
-- Indexes for table `gap_master_lsm`
--
ALTER TABLE `gap_master_lsm`
  ADD PRIMARY KEY (`id_lsm`);

--
-- Indexes for table `gap_master_objek_kerjasama`
--
ALTER TABLE `gap_master_objek_kerjasama`
  ADD PRIMARY KEY (`id_objek_kerjasama`);

--
-- Indexes for table `gap_non_perkara`
--
ALTER TABLE `gap_non_perkara`
  ADD PRIMARY KEY (`id_non_pekara`);

--
-- Indexes for table `gap_pengelolaan_kebun`
--
ALTER TABLE `gap_pengelolaan_kebun`
  ADD PRIMARY KEY (`id_olah_keb`);

--
-- Indexes for table `gap_perkara`
--
ALTER TABLE `gap_perkara`
  ADD PRIMARY KEY (`id_perkara`);

--
-- Indexes for table `gap_pertanahan`
--
ALTER TABLE `gap_pertanahan`
  ADD PRIMARY KEY (`id_pertanahan`);

--
-- Indexes for table `gap_prmslhan_hub_industrial`
--
ALTER TABLE `gap_prmslhan_hub_industrial`
  ADD PRIMARY KEY (`id_permasalahan`);

--
-- Indexes for table `gap_sosial_lingkungan`
--
ALTER TABLE `gap_sosial_lingkungan`
  ADD PRIMARY KEY (`id_sos_lik`);

--
-- Indexes for table `histori_download_dokumen`
--
ALTER TABLE `histori_download_dokumen`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `histori_pembarui_dokumen`
--
ALTER TABLE `histori_pembarui_dokumen`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_dokumen` (`id_dokumen`);

--
-- Indexes for table `hkm_dokumen`
--
ALTER TABLE `hkm_dokumen`
  ADD PRIMARY KEY (`id_dokumen`);

--
-- Indexes for table `hkm_dokumen_download`
--
ALTER TABLE `hkm_dokumen_download`
  ADD PRIMARY KEY (`id_download`);

--
-- Indexes for table `hkm_dokumen_proses`
--
ALTER TABLE `hkm_dokumen_proses`
  ADD PRIMARY KEY (`id_proses`);

--
-- Indexes for table `hkm_master_jenis_dokumen`
--
ALTER TABLE `hkm_master_jenis_dokumen`
  ADD PRIMARY KEY (`id_jenis_dokumen`);

--
-- Indexes for table `tb_dokumen`
--
ALTER TABLE `tb_dokumen`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_user` (`id_user`);

--
-- Indexes for table `tb_master_bagian`
--
ALTER TABLE `tb_master_bagian`
  ADD PRIMARY KEY (`id_bagian`);

--
-- Indexes for table `tb_master_jenis_dok`
--
ALTER TABLE `tb_master_jenis_dok`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tb_role`
--
ALTER TABLE `tb_role`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tb_user`
--
ALTER TABLE `tb_user`
  ADD PRIMARY KEY (`id`),
  ADD KEY `role_id` (`role_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `gap_demografi_t_k`
--
ALTER TABLE `gap_demografi_t_k`
  MODIFY `id_demografi_t_k` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `gap_histori_demografi`
--
ALTER TABLE `gap_histori_demografi`
  MODIFY `id_histori_demograf` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `gap_histori_infrastruktur_pendukung`
--
ALTER TABLE `gap_histori_infrastruktur_pendukung`
  MODIFY `id_histori_infra_pen` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `gap_histori_legal_ijin`
--
ALTER TABLE `gap_histori_legal_ijin`
  MODIFY `id_histori_li` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=15;
--
-- AUTO_INCREMENT for table `gap_histori_pengelolaan_kebun`
--
ALTER TABLE `gap_histori_pengelolaan_kebun`
  MODIFY `id_histori_peng_keb` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `gap_histori_perkara`
--
ALTER TABLE `gap_histori_perkara`
  MODIFY `id_histori_perkara` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `gap_histori_prmslhan_hub_industrial`
--
ALTER TABLE `gap_histori_prmslhan_hub_industrial`
  MODIFY `id_histori_permasalahan` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT for table `gap_histori_sos_ling`
--
ALTER TABLE `gap_histori_sos_ling`
  MODIFY `id_histori_sos_ling` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `gap_infrastruktur_pendukung`
--
ALTER TABLE `gap_infrastruktur_pendukung`
  MODIFY `id_infra_pen` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `gap_jenis_kepatuhan`
--
ALTER TABLE `gap_jenis_kepatuhan`
  MODIFY `id_jen_kep` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=12;
--
-- AUTO_INCREMENT for table `gap_kat_pertanahan`
--
ALTER TABLE `gap_kat_pertanahan`
  MODIFY `id_kat_tanah` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=16;
--
-- AUTO_INCREMENT for table `gap_legal_ijin`
--
ALTER TABLE `gap_legal_ijin`
  MODIFY `id_legal_ijin` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `gap_master_hgu`
--
ALTER TABLE `gap_master_hgu`
  MODIFY `id_hgu` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `gap_master_jenis_tenaga_kerja`
--
ALTER TABLE `gap_master_jenis_tenaga_kerja`
  MODIFY `id_jenis_t_n` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `gap_master_kerjasama`
--
ALTER TABLE `gap_master_kerjasama`
  MODIFY `id_kerjasama` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `gap_master_lsm`
--
ALTER TABLE `gap_master_lsm`
  MODIFY `id_lsm` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `gap_master_objek_kerjasama`
--
ALTER TABLE `gap_master_objek_kerjasama`
  MODIFY `id_objek_kerjasama` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `gap_non_perkara`
--
ALTER TABLE `gap_non_perkara`
  MODIFY `id_non_pekara` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `gap_pengelolaan_kebun`
--
ALTER TABLE `gap_pengelolaan_kebun`
  MODIFY `id_olah_keb` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `gap_perkara`
--
ALTER TABLE `gap_perkara`
  MODIFY `id_perkara` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `gap_pertanahan`
--
ALTER TABLE `gap_pertanahan`
  MODIFY `id_pertanahan` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `gap_prmslhan_hub_industrial`
--
ALTER TABLE `gap_prmslhan_hub_industrial`
  MODIFY `id_permasalahan` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `gap_sosial_lingkungan`
--
ALTER TABLE `gap_sosial_lingkungan`
  MODIFY `id_sos_lik` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `histori_download_dokumen`
--
ALTER TABLE `histori_download_dokumen`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `histori_pembarui_dokumen`
--
ALTER TABLE `histori_pembarui_dokumen`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=18;
--
-- AUTO_INCREMENT for table `hkm_dokumen`
--
ALTER TABLE `hkm_dokumen`
  MODIFY `id_dokumen` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `hkm_dokumen_download`
--
ALTER TABLE `hkm_dokumen_download`
  MODIFY `id_download` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `hkm_dokumen_proses`
--
ALTER TABLE `hkm_dokumen_proses`
  MODIFY `id_proses` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `hkm_master_jenis_dokumen`
--
ALTER TABLE `hkm_master_jenis_dokumen`
  MODIFY `id_jenis_dokumen` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `tb_dokumen`
--
ALTER TABLE `tb_dokumen`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=16;
--
-- AUTO_INCREMENT for table `tb_master_bagian`
--
ALTER TABLE `tb_master_bagian`
  MODIFY `id_bagian` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=52;
--
-- AUTO_INCREMENT for table `tb_master_jenis_dok`
--
ALTER TABLE `tb_master_jenis_dok`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=12;
--
-- AUTO_INCREMENT for table `tb_role`
--
ALTER TABLE `tb_role`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `tb_user`
--
ALTER TABLE `tb_user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
