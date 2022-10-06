-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Anamakine: localhost
-- Üretim Zamanı: 30 Ağu 2022, 10:59:50
-- Sunucu sürümü: 5.6.51
-- PHP Sürümü: 7.2.34

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Veritabanı: `biltekbi_lisim`
--

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `cihazlar`
--

CREATE TABLE `cihazlar` (
  `id` int(11) NOT NULL,
  `servis_no` varchar(50) DEFAULT NULL,
  `takip_numarasi` int(11) NOT NULL,
  `musteri_kod` varchar(20) DEFAULT NULL,
  `musteri_adi` varchar(255) NOT NULL,
  `adres` varchar(255) NOT NULL,
  `telefon_numarasi` varchar(255) NOT NULL,
  `cihaz_turu` int(11) NOT NULL,
  `sorumlu` int(11) NOT NULL DEFAULT '0',
  `cihaz` varchar(255) NOT NULL,
  `cihaz_modeli` varchar(255) NOT NULL,
  `seri_no` varchar(255) NOT NULL,
  `cihaz_sifresi` varchar(50) DEFAULT NULL,
  `hasar_tespiti` varchar(255) NOT NULL,
  `cihazdaki_hasar` int(11) NOT NULL,
  `ariza_aciklamasi` longtext,
  `servis_turu` int(11) NOT NULL,
  `yedek_durumu` int(11) NOT NULL,
  `teslim_alinanlar` longtext,
  `yapilan_islem_aciklamasi` longtext,
  `teslim_edildi` int(11) NOT NULL DEFAULT '0',
  `tarih` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `bildirim_tarihi` datetime DEFAULT NULL,
  `cikis_tarihi` datetime DEFAULT NULL,
  `guncel_durum` int(11) NOT NULL DEFAULT '0',
  `tahsilat_sekli` int(11) NOT NULL DEFAULT '0',
  `i_stok_kod_1` varchar(50) DEFAULT NULL,
  `i_ad_1` varchar(255) DEFAULT NULL,
  `i_birim_fiyat_1` decimal(28,2) NOT NULL DEFAULT '0.00',
  `i_miktar_1` int(11) NOT NULL DEFAULT '0',
  `i_kdv_1` decimal(5,2) NOT NULL DEFAULT '0.00',
  `i_stok_kod_2` varchar(50) DEFAULT NULL,
  `i_ad_2` varchar(255) DEFAULT NULL,
  `i_birim_fiyat_2` decimal(28,2) NOT NULL DEFAULT '0.00',
  `i_miktar_2` int(11) NOT NULL DEFAULT '0',
  `i_kdv_2` decimal(5,2) NOT NULL DEFAULT '0.00',
  `i_stok_kod_3` varchar(50) DEFAULT NULL,
  `i_ad_3` varchar(255) DEFAULT NULL,
  `i_birim_fiyat_3` decimal(28,2) NOT NULL DEFAULT '0.00',
  `i_miktar_3` int(11) NOT NULL DEFAULT '0',
  `i_kdv_3` decimal(5,2) NOT NULL DEFAULT '0.00',
  `i_stok_kod_4` varchar(50) DEFAULT NULL,
  `i_ad_4` varchar(255) DEFAULT NULL,
  `i_birim_fiyat_4` decimal(28,2) NOT NULL DEFAULT '0.00',
  `i_miktar_4` int(11) NOT NULL DEFAULT '0',
  `i_kdv_4` decimal(5,2) NOT NULL DEFAULT '0.00',
  `i_stok_kod_5` varchar(50) DEFAULT NULL,
  `i_ad_5` varchar(255) DEFAULT NULL,
  `i_birim_fiyat_5` decimal(28,2) NOT NULL DEFAULT '0.00',
  `i_miktar_5` int(11) NOT NULL DEFAULT '0',
  `i_kdv_5` decimal(5,2) NOT NULL DEFAULT '0.00',
  `i_stok_kod_6` varchar(50) DEFAULT NULL,
  `i_ad_6` varchar(255) DEFAULT NULL,
  `i_birim_fiyat_6` decimal(28,2) NOT NULL DEFAULT '0.00',
  `i_miktar_6` int(11) NOT NULL DEFAULT '0',
  `i_kdv_6` decimal(5,2) NOT NULL DEFAULT '0.00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `cihazturleri`
--

CREATE TABLE `cihazturleri` (
  `id` int(11) NOT NULL,
  `isim` varchar(255) NOT NULL,
  `sifre` tinyint(3) UNSIGNED NOT NULL DEFAULT '0'
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
  `yonetici` int(10) NOT NULL DEFAULT '0'
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
  `silinme_tarihi` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `ci_sessions`
--

CREATE TABLE `ci_sessions` (
        `id` varchar(128) NOT NULL,
        `ip_address` varchar(45) NOT NULL,
        `timestamp` int(10) unsigned DEFAULT 0 NOT NULL,
        `data` blob NOT NULL,
        KEY `ci_sessions_timestamp` (`timestamp`)
);

--
-- Dökümü yapılmış tablolar için indeksler
--

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
-- Tablo için indeksler `ci_sessions`
--
ALTER TABLE `ci_sessions`
  ADD PRIMARY KEY (`id`);
--
-- Dökümü yapılmış tablolar için AUTO_INCREMENT değeri
--

--
-- Tablo için AUTO_INCREMENT değeri `cihazlar`
--
ALTER TABLE `cihazlar`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Tablo için AUTO_INCREMENT değeri `cihazturleri`
--
ALTER TABLE `cihazturleri`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Tablo için AUTO_INCREMENT değeri `kullanicilar`
--
ALTER TABLE `kullanicilar`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Tablo için AUTO_INCREMENT değeri `medyalar`
--
ALTER TABLE `medyalar`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
