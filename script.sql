-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Dec 06, 2023 at 12:23 PM
-- Server version: 8.0.33
-- PHP Version: 7.4.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `biltekbi_lisim`
--

-- --------------------------------------------------------

--
-- Table structure for table `ts2_cihazlar`
--

CREATE TABLE `ts2_cihazlar` (
  `id` int NOT NULL,
  `servis_no` varchar(50) DEFAULT NULL,
  `takip_numarasi` int NOT NULL,
  `musteri_kod` int DEFAULT NULL,
  `musteri_adi` varchar(255) NOT NULL,
  `adres` varchar(255) NOT NULL,
  `telefon_numarasi` varchar(255) NOT NULL,
  `cihaz_turu` int NOT NULL,
  `sorumlu` int NOT NULL DEFAULT '0',
  `cihaz` varchar(255) NOT NULL,
  `cihaz_modeli` varchar(255) NOT NULL,
  `seri_no` varchar(255) NOT NULL,
  `cihaz_sifresi` varchar(50) DEFAULT NULL,
  `hasar_tespiti` varchar(255) NOT NULL,
  `cihazdaki_hasar` int NOT NULL,
  `ariza_aciklamasi` longtext,
  `servis_turu` int NOT NULL,
  `yedek_durumu` int NOT NULL,
  `teslim_alinanlar` longtext,
  `yapilan_islem_aciklamasi` longtext,
  `teslim_edildi` int NOT NULL DEFAULT '0',
  `tarih` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `bildirim_tarihi` datetime DEFAULT NULL,
  `cikis_tarihi` datetime DEFAULT NULL,
  `guncel_durum` int NOT NULL DEFAULT '0',
  `tahsilat_sekli` int NOT NULL DEFAULT '0',
  `fatura_durumu` tinyint(1) NOT NULL DEFAULT '0',
  `fis_no` varchar(50) NOT NULL DEFAULT '',
  `i_stok_kod_1` varchar(50) DEFAULT NULL,
  `i_ad_1` varchar(255) DEFAULT NULL,
  `i_birim_fiyat_1` decimal(28,2) NOT NULL DEFAULT '0.00',
  `i_miktar_1` int NOT NULL DEFAULT '0',
  `i_kdv_1` decimal(5,2) NOT NULL DEFAULT '0.00',
  `i_stok_kod_2` varchar(50) DEFAULT NULL,
  `i_ad_2` varchar(255) DEFAULT NULL,
  `i_birim_fiyat_2` decimal(28,2) NOT NULL DEFAULT '0.00',
  `i_miktar_2` int NOT NULL DEFAULT '0',
  `i_kdv_2` decimal(5,2) NOT NULL DEFAULT '0.00',
  `i_stok_kod_3` varchar(50) DEFAULT NULL,
  `i_ad_3` varchar(255) DEFAULT NULL,
  `i_birim_fiyat_3` decimal(28,2) NOT NULL DEFAULT '0.00',
  `i_miktar_3` int NOT NULL DEFAULT '0',
  `i_kdv_3` decimal(5,2) NOT NULL DEFAULT '0.00',
  `i_stok_kod_4` varchar(50) DEFAULT NULL,
  `i_ad_4` varchar(255) DEFAULT NULL,
  `i_birim_fiyat_4` decimal(28,2) NOT NULL DEFAULT '0.00',
  `i_miktar_4` int NOT NULL DEFAULT '0',
  `i_kdv_4` decimal(5,2) NOT NULL DEFAULT '0.00',
  `i_stok_kod_5` varchar(50) DEFAULT NULL,
  `i_ad_5` varchar(255) DEFAULT NULL,
  `i_birim_fiyat_5` decimal(28,2) NOT NULL DEFAULT '0.00',
  `i_miktar_5` int NOT NULL DEFAULT '0',
  `i_kdv_5` decimal(5,2) NOT NULL DEFAULT '0.00',
  `i_stok_kod_6` varchar(50) DEFAULT NULL,
  `i_ad_6` varchar(255) DEFAULT NULL,
  `i_birim_fiyat_6` decimal(28,2) NOT NULL DEFAULT '0.00',
  `i_miktar_6` int NOT NULL DEFAULT '0',
  `i_kdv_6` decimal(5,2) NOT NULL DEFAULT '0.00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `ts2_cihazturleri`
--

CREATE TABLE `ts2_cihazturleri` (
  `id` int NOT NULL,
  `isim` varchar(255) NOT NULL,
  `sifre` tinyint UNSIGNED NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `ts2_cihazturleri`
--

INSERT INTO `ts2_cihazturleri` (`id`, `isim`, `sifre`) VALUES
(1, 'Bilgisayar', 1),
(2, 'Tablet - Telefon', 1),
(3, 'Yazıcı', 0),
(4, 'Çevre Birimleri', 0),
(5, 'Toner/Sarf Malzeme Teslimi', 0);

-- --------------------------------------------------------

--
-- Table structure for table `ts2_guncelleme`
--

CREATE TABLE `ts2_guncelleme` (
  `id` int NOT NULL,
  `guncelleme_tarihi` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `ts2_islemler`
--

CREATE TABLE `ts2_islemler` (
  `id` int NOT NULL,
  `cihaz_id` int NOT NULL,
  `islem_sayisi` int NOT NULL,
  `ad` varchar(255) NOT NULL,
  `birim_fiyat` decimal(28,2) NOT NULL DEFAULT '0.00',
  `miktar` int NOT NULL DEFAULT '0',
  `kdv` decimal(5,2) NOT NULL DEFAULT '0.00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `ts2_kullanicilar`
--

CREATE TABLE `ts2_kullanicilar` (
  `id` int NOT NULL,
  `kullanici_adi` varchar(50) DEFAULT NULL,
  `ad_soyad` varchar(100) DEFAULT NULL,
  `sifre` varchar(255) NOT NULL,
  `yonetici` int NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `ts2_kullanicilar`
--

INSERT INTO `ts2_kullanicilar` (`id`, `kullanici_adi`, `ad_soyad`, `sifre`, `yonetici`) VALUES
(1, 'OZAY', 'Özay AKCAN', '$2y$10$l8YCw.d56otWDtcTL1z9KuUTdWb6lbQ1vz4m1yfvnPcJWcJ3QTHfW', 1);

-- --------------------------------------------------------

--
-- Table structure for table `ts2_medyalar`
--

CREATE TABLE `ts2_medyalar` (
  `id` int NOT NULL,
  `cihaz_id` int NOT NULL,
  `konum` varchar(255) NOT NULL,
  `tur` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `ts2_musteriler`
--

CREATE TABLE `ts2_musteriler` (
  `id` int NOT NULL,
  `musteri_adi` varchar(255) NOT NULL,
  `adres` varchar(255) NOT NULL,
  `telefon_numarasi` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `ts2_ozelid`
--

CREATE TABLE `ts2_ozelid` (
  `id_adi` varchar(50) NOT NULL,
  `id_grup` varchar(10) NOT NULL,
  `id_val` int UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `ts2_silinencihazlar`
--

CREATE TABLE `ts2_silinencihazlar` (
  `id` int NOT NULL,
  `silinme_tarihi` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `ts2_tahsilatsekilleri`
--

CREATE TABLE `ts2_tahsilatsekilleri` (
  `id` int NOT NULL,
  `isim` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `ts2_tahsilatsekilleri`
--

INSERT INTO `ts2_tahsilatsekilleri` (`id`, `isim`) VALUES
(1, 'Nakit'),
(2, 'Kredi Kartı'),
(3, 'Mail Order'),
(4, 'Açık Hesap'),
(5, 'Banka Havalesi');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `ts2_cihazlar`
--
ALTER TABLE `ts2_cihazlar`
  ADD PRIMARY KEY (`id`),
  ADD KEY `TakipNo` (`takip_numarasi`);

--
-- Indexes for table `ts2_cihazturleri`
--
ALTER TABLE `ts2_cihazturleri`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ts2_guncelleme`
--
ALTER TABLE `ts2_guncelleme`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ts2_islemler`
--
ALTER TABLE `ts2_islemler`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ts2_kullanicilar`
--
ALTER TABLE `ts2_kullanicilar`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ts2_medyalar`
--
ALTER TABLE `ts2_medyalar`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ts2_musteriler`
--
ALTER TABLE `ts2_musteriler`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ts2_ozelid`
--
ALTER TABLE `ts2_ozelid`
  ADD PRIMARY KEY (`id_adi`);

--
-- Indexes for table `ts2_silinencihazlar`
--
ALTER TABLE `ts2_silinencihazlar`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ts2_tahsilatsekilleri`
--
ALTER TABLE `ts2_tahsilatsekilleri`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `ts2_cihazlar`
--
ALTER TABLE `ts2_cihazlar`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ts2_cihazturleri`
--
ALTER TABLE `ts2_cihazturleri`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `ts2_guncelleme`
--
ALTER TABLE `ts2_guncelleme`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ts2_islemler`
--
ALTER TABLE `ts2_islemler`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ts2_kullanicilar`
--
ALTER TABLE `ts2_kullanicilar`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `ts2_medyalar`
--
ALTER TABLE `ts2_medyalar`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ts2_musteriler`
--
ALTER TABLE `ts2_musteriler`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ts2_tahsilatsekilleri`
--
ALTER TABLE `ts2_tahsilatsekilleri`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
