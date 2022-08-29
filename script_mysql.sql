-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Anamakine: 127.0.0.1
-- Üretim Zamanı: 29 Ağu 2022, 13:35:11
-- Sunucu sürümü: 10.4.24-MariaDB
-- PHP Sürümü: 7.4.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Veritabanı: `teknik_servis`
--



-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `cihazlar`
--

CREATE TABLE `cihazlar` (
  `id` int(11) NOT NULL,
  `musteri_kod` varchar(20) DEFAULT NULL,
  `musteri_adi` varchar(255) NOT NULL,
  `adres` varchar(255) NOT NULL,
  `telefon_numarasi` varchar(255) NOT NULL,
  `cihaz_turu` int(11) NOT NULL,
  `cihaz` varchar(255) NOT NULL,
  `cihaz_modeli` varchar(255) NOT NULL,
  `seri_no` varchar(255) NOT NULL,
  `hasar_tespiti` varchar(255) NOT NULL,
  `cihazdaki_hasar` tinyint(3) UNSIGNED NOT NULL,
  `ariza_aciklamasi` longtext DEFAULT NULL,
  `servis_turu` tinyint(3) UNSIGNED NOT NULL,
  `yedek_durumu` tinyint(3) UNSIGNED NOT NULL,
  `teslim_alinanlar` longtext DEFAULT NULL,
  `yapilan_islem_aciklamasi` longtext DEFAULT NULL,
  `teslim_edildi` tinyint(3) UNSIGNED NOT NULL DEFAULT 0,
  `tarih` datetime NOT NULL,
  `bildirim_tarihi` datetime DEFAULT NULL,
  `cikis_tarihi` datetime DEFAULT NULL,
  `guncel_durum` tinyint(3) UNSIGNED NOT NULL DEFAULT 0,
  `i_stok_kod_1` varchar(50) DEFAULT NULL,
  `i_ad_1` varchar(255) DEFAULT NULL,
  `i_birim_fiyat_1` decimal(28,2) NOT NULL DEFAULT 0.00,
  `i_miktar_1` int(11) NOT NULL DEFAULT 0,
  `i_kdv_1` decimal(5,2) NOT NULL DEFAULT 0.00,
  `i_stok_kod_2` varchar(50) DEFAULT NULL,
  `i_ad_2` varchar(255) DEFAULT NULL,
  `i_birim_fiyat_2` decimal(28,2) NOT NULL DEFAULT 0.00,
  `i_miktar_2` int(11) NOT NULL DEFAULT 0,
  `i_kdv_2` decimal(5,2) NOT NULL DEFAULT 0.00,
  `i_stok_kod_3` varchar(50) DEFAULT NULL,
  `i_ad_3` varchar(255) DEFAULT NULL,
  `i_birim_fiyat_3` decimal(28,2) NOT NULL DEFAULT 0.00,
  `i_miktar_3` int(11) NOT NULL DEFAULT 0,
  `i_kdv_3` decimal(5,2) NOT NULL DEFAULT 0.00,
  `i_stok_kod_4` varchar(50) DEFAULT NULL,
  `i_ad_4` varchar(255) DEFAULT NULL,
  `i_birim_fiyat_4` decimal(28,2) NOT NULL DEFAULT 0.00,
  `i_miktar_4` int(11) NOT NULL DEFAULT 0,
  `i_kdv_4` decimal(5,2) NOT NULL DEFAULT 0.00,
  `i_stok_kod_5` varchar(50) DEFAULT NULL,
  `i_ad_5` varchar(255) DEFAULT NULL,
  `i_birim_fiyat_5` decimal(28,2) NOT NULL DEFAULT 0.00,
  `i_miktar_5` int(11) NOT NULL DEFAULT 0,
  `i_kdv_5` decimal(5,2) NOT NULL DEFAULT 0.00,
  `cihaz_sifresi` varchar(50) DEFAULT NULL,
  `servis_no` varchar(50) DEFAULT NULL,
  `sorumlu` int(11) NOT NULL DEFAULT 0,
  `i_stok_kod_6` varchar(50) DEFAULT NULL,
  `i_ad_6` varchar(255) DEFAULT NULL,
  `i_birim_fiyat_6` decimal(28,2) NOT NULL DEFAULT 0.00,
  `i_miktar_6` int(11) NOT NULL DEFAULT 0,
  `i_kdv_6` decimal(5,2) NOT NULL DEFAULT 0.00,
  `tahsilat_sekli` tinyint(3) UNSIGNED NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `cihazturleri`
--

CREATE TABLE `cihazturleri` (
  `id` int(11) NOT NULL,
  `isim` varchar(255) NOT NULL,
  `sifre` tinyint(3) UNSIGNED NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `kullanicilar`
--

CREATE TABLE `kullanicilar` (
  `id` int(11) NOT NULL,
  `kullanici_adi` varchar(50) DEFAULT NULL,
  `ad_soyad` varchar(100) DEFAULT NULL,
  `sifre` varchar(255) NOT NULL,
  `yonetici` tinyint(3) UNSIGNED NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `medyalar`
--

CREATE TABLE `medyalar` (
  `id` int(11) NOT NULL,
  `cihaz_id` int(11) NOT NULL,
  `konum` varchar(255) NOT NULL,
  `tur` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `ozelid`
--

CREATE TABLE `ozelid` (
  `id_adi` varchar(50) NOT NULL,
  `id_grup` varchar(10) NOT NULL,
  `id_val` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `silinencihazlar`
--

CREATE TABLE `silinencihazlar` (
  `id` int(11) NOT NULL,
  `silinme_tarihi` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


--
-- Tablo için indeksler `cihazlar`
--
ALTER TABLE `cihazlar`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `cihazturleri`
--
ALTER TABLE `cihazturleri`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `kullanicilar`
--
ALTER TABLE `kullanicilar`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `medyalar`
--
ALTER TABLE `medyalar`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `ozelid`
--
ALTER TABLE `ozelid`
  ADD PRIMARY KEY (`id_adi`);

--
-- Tablo için indeksler `silinencihazlar`
--
ALTER TABLE `silinencihazlar`
  ADD PRIMARY KEY (`id`);

--
-- Dökümü yapılmış tablolar için AUTO_INCREMENT değeri
--

--
-- Tablo için AUTO_INCREMENT değeri `cihazlar`
--
ALTER TABLE `cihazlar`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=96;

--
-- Tablo için AUTO_INCREMENT değeri `cihazturleri`
--
ALTER TABLE `cihazturleri`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Tablo için AUTO_INCREMENT değeri `kullanicilar`
--
ALTER TABLE `kullanicilar`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- Tablo için AUTO_INCREMENT değeri `medyalar`
--
ALTER TABLE `medyalar`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;



/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
