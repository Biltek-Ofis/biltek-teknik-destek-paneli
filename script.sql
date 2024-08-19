-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Anamakine: 127.0.0.1
-- Üretim Zamanı: 19 Ağu 2024, 08:05:57
-- Sunucu sürümü: 10.4.17-MariaDB
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
-- Tablo için tablo yapısı `ts1_cihazdurumlari`
--

CREATE TABLE `ts1_cihazdurumlari` (
  `id` int(11) NOT NULL,
  `siralama` int(11) NOT NULL,
  `durum` varchar(255) CHARACTER SET utf8 NOT NULL,
  `renk` varchar(255) COLLATE utf8_turkish_ci NOT NULL,
  `kilitle` tinyint(1) NOT NULL DEFAULT 0,
  `varsayilan` tinyint(4) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci;

--
-- Tablo döküm verisi `ts1_cihazdurumlari`
--

INSERT INTO `ts1_cihazdurumlari` (`id`, `siralama`, `durum`, `renk`, `kilitle`, `varsayilan`) VALUES
(1, 1, 'Sırada Bekliyor', 'bg-warning', 0, 1),
(2, 2, 'Arıza Tespiti Yapılıyor', 'bg-warning', 0, 0),
(3, 3, 'Yedek Parça Bekleniyor', 'bg-warning', 0, 0),
(4, 5, 'Merkez Servise Gönderildi', 'bg-pink', 0, 0),
(5, 4, 'Fiyat Onayı Bekleniyor', 'bg-warning', 0, 0),
(6, 6, 'Fiyat Onaylandı', 'bg-primary', 0, 0),
(7, 7, 'Fiyat Onaylanmadı', 'bg-danger', 0, 0),
(8, 8, 'İade Edildi', 'bg-danger', 0, 0),
(9, 9, 'Teslim Edilmeye Hazır', 'bg-primary', 0, 0),
(10, 10, 'Teslim Edildi / Ödeme Alınmadı', 'bg-danger', 0, 0),
(11, 11, 'Teslim Edildi', 'bg-success', 0, 0);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `ts1_cihazlar`
--

CREATE TABLE `ts1_cihazlar` (
  `id` int(11) NOT NULL,
  `servis_no` varchar(50) DEFAULT NULL,
  `takip_numarasi` int(11) NOT NULL,
  `musteri_kod` int(11) DEFAULT NULL,
  `musteri_adi` varchar(255) NOT NULL,
  `adres` varchar(255) NOT NULL,
  `telefon_numarasi` varchar(255) NOT NULL,
  `cihaz_turu` int(11) NOT NULL,
  `sorumlu` int(11) NOT NULL DEFAULT 0,
  `cihaz` varchar(255) NOT NULL,
  `cihaz_modeli` varchar(255) NOT NULL,
  `seri_no` varchar(255) NOT NULL,
  `cihaz_sifresi` varchar(50) DEFAULT NULL,
  `hasar_tespiti` varchar(255) NOT NULL,
  `cihazdaki_hasar` int(11) NOT NULL,
  `ariza_aciklamasi` longtext DEFAULT NULL,
  `servis_turu` int(11) NOT NULL,
  `yedek_durumu` int(11) NOT NULL,
  `teslim_alinanlar` longtext DEFAULT NULL,
  `yapilan_islem_aciklamasi` longtext DEFAULT NULL,
  `teslim_edildi` int(11) NOT NULL DEFAULT 0,
  `tarih` datetime NOT NULL DEFAULT current_timestamp(),
  `bildirim_tarihi` datetime DEFAULT NULL,
  `cikis_tarihi` datetime DEFAULT NULL,
  `guncel_durum` int(11) NOT NULL DEFAULT 0,
  `tahsilat_sekli` int(11) NOT NULL DEFAULT 0,
  `fatura_durumu` tinyint(1) NOT NULL DEFAULT 0,
  `fis_no` varchar(50) NOT NULL DEFAULT '',
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
  `i_stok_kod_6` varchar(50) DEFAULT NULL,
  `i_ad_6` varchar(255) DEFAULT NULL,
  `i_birim_fiyat_6` decimal(28,2) NOT NULL DEFAULT 0.00,
  `i_miktar_6` int(11) NOT NULL DEFAULT 0,
  `i_kdv_6` decimal(5,2) NOT NULL DEFAULT 0.00
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `ts1_cihazturleri`
--

CREATE TABLE `ts1_cihazturleri` (
  `id` int(11) NOT NULL,
  `isim` varchar(255) NOT NULL,
  `sifre` tinyint(3) UNSIGNED NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Tablo döküm verisi `ts1_cihazturleri`
--

INSERT INTO `ts1_cihazturleri` (`id`, `isim`, `sifre`) VALUES
(1, 'Bilgisayar', 1),
(2, 'Tablet - Telefon', 1),
(3, 'Yazıcı', 0),
(4, 'Çevre Birimleri', 0),
(5, 'Toner/Sarf Malzeme Teslimi', 0);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `ts1_guncelleme`
--

CREATE TABLE `ts1_guncelleme` (
  `id` int(11) NOT NULL,
  `guncelleme_tarihi` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Tablo döküm verisi `ts1_guncelleme`
--

INSERT INTO `ts1_guncelleme` (`id`, `guncelleme_tarihi`) VALUES
(1, 1721204368);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `ts1_islemler`
--

CREATE TABLE `ts1_islemler` (
  `id` int(11) NOT NULL,
  `cihaz_id` int(11) NOT NULL,
  `islem_sayisi` int(1) NOT NULL,
  `ad` varchar(255) NOT NULL,
  `birim_fiyat` decimal(28,2) NOT NULL DEFAULT 0.00,
  `miktar` int(11) NOT NULL DEFAULT 0,
  `kdv` decimal(5,2) NOT NULL DEFAULT 0.00
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `ts1_kullanicilar`
--

CREATE TABLE `ts1_kullanicilar` (
  `id` int(11) NOT NULL,
  `kullanici_adi` varchar(50) DEFAULT NULL,
  `ad_soyad` varchar(100) DEFAULT NULL,
  `sifre` varchar(255) NOT NULL,
  `yonetici` int(10) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Tablo döküm verisi `ts1_kullanicilar`
--

INSERT INTO `ts1_kullanicilar` (`id`, `kullanici_adi`, `ad_soyad`, `sifre`, `yonetici`) VALUES
(3, 'HUSNU', 'Hüsnü SÖZÜTOK', '$2y$10$sSaswokEL5GoLaKg8N.64.o6lzhwzaMlOAZn.478jVMC/EqfCthEu', 0),
(4, 'PELIN', 'RUKİYE AKTÜRK', '$2y$10$wqUotkJBOCcFWTvLRCmd/OuGLylSNTi/.QfSGH8pzT28Wwx0XF2wO', 1),
(5, 'ISILTAN', 'Işıltan KÜÇÜKKAYA', '$2y$10$ziTZg6lOAQt2I8WzEc2CG.IW3tIawb388KaX0X6.1U5sthjReF1XC', 0),
(9, 'RUKIYE', 'Rukiye AKTÜRK', '$2y$10$LgO1yUTHOF.EZXiYtevp6OFloW0ZkRsJJMvNSVO.Hy1SYFVfnM9qe', 1),
(12, 'OZAY', 'Özay AKCAN', '$2y$10$l8YCw.d56otWDtcTL1z9KuUTdWb6lbQ1vz4m1yfvnPcJWcJ3QTHfW', 1),
(13, 'YUKSEL', 'YÜKSEL GÜMÜŞ', '$2y$10$9CUynqZ5p4qdBBqNaVd.k..mLriP5Plf.AmRb2sx8AFGnzQ07e.wi', 0);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `ts1_medyalar`
--

CREATE TABLE `ts1_medyalar` (
  `id` int(11) NOT NULL,
  `cihaz_id` int(11) NOT NULL,
  `konum` varchar(255) NOT NULL,
  `tur` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `ts1_musteriler`
--

CREATE TABLE `ts1_musteriler` (
  `id` int(11) NOT NULL,
  `musteri_adi` varchar(255) NOT NULL,
  `adres` varchar(255) NOT NULL,
  `telefon_numarasi` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `ts1_ozelid`
--

CREATE TABLE `ts1_ozelid` (
  `id_adi` varchar(50) NOT NULL,
  `id_grup` varchar(10) NOT NULL,
  `id_val` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Tablo döküm verisi `ts1_ozelid`
--

INSERT INTO `ts1_ozelid` (`id_adi`, `id_grup`, `id_val`) VALUES
('2022', '2022', 638),
('2023', '2023', 1380),
('2024', '2024', 568);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `ts1_silinencihazlar`
--

CREATE TABLE `ts1_silinencihazlar` (
  `id` int(11) NOT NULL,
  `silinme_tarihi` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `ts1_tahsilatsekilleri`
--

CREATE TABLE `ts1_tahsilatsekilleri` (
  `id` int(11) NOT NULL,
  `isim` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Tablo döküm verisi `ts1_tahsilatsekilleri`
--

INSERT INTO `ts1_tahsilatsekilleri` (`id`, `isim`) VALUES
(1, 'Nakit'),
(2, 'Kredi Kartı'),
(3, 'Mail Order'),
(4, 'Açık Hesap'),
(5, 'Banka Havalesi');

--
-- Dökümü yapılmış tablolar için indeksler
--

--
-- Tablo için indeksler `ts1_cihazdurumlari`
--
ALTER TABLE `ts1_cihazdurumlari`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `siralama` (`siralama`);

--
-- Tablo için indeksler `ts1_cihazlar`
--
ALTER TABLE `ts1_cihazlar`
  ADD PRIMARY KEY (`id`),
  ADD KEY `TakipNo` (`takip_numarasi`);

--
-- Tablo için indeksler `ts1_cihazturleri`
--
ALTER TABLE `ts1_cihazturleri`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `ts1_guncelleme`
--
ALTER TABLE `ts1_guncelleme`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `ts1_islemler`
--
ALTER TABLE `ts1_islemler`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `ts1_kullanicilar`
--
ALTER TABLE `ts1_kullanicilar`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `ts1_medyalar`
--
ALTER TABLE `ts1_medyalar`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `ts1_musteriler`
--
ALTER TABLE `ts1_musteriler`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `ts1_ozelid`
--
ALTER TABLE `ts1_ozelid`
  ADD PRIMARY KEY (`id_adi`);

--
-- Tablo için indeksler `ts1_silinencihazlar`
--
ALTER TABLE `ts1_silinencihazlar`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `ts1_tahsilatsekilleri`
--
ALTER TABLE `ts1_tahsilatsekilleri`
  ADD PRIMARY KEY (`id`);

--
-- Dökümü yapılmış tablolar için AUTO_INCREMENT değeri
--

--
-- Tablo için AUTO_INCREMENT değeri `ts1_cihazdurumlari`
--
ALTER TABLE `ts1_cihazdurumlari`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- Tablo için AUTO_INCREMENT değeri `ts1_cihazlar`
--
ALTER TABLE `ts1_cihazlar`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

--
-- Tablo için AUTO_INCREMENT değeri `ts1_cihazturleri`
--
ALTER TABLE `ts1_cihazturleri`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Tablo için AUTO_INCREMENT değeri `ts1_guncelleme`
--
ALTER TABLE `ts1_guncelleme`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Tablo için AUTO_INCREMENT değeri `ts1_islemler`
--
ALTER TABLE `ts1_islemler`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

--
-- Tablo için AUTO_INCREMENT değeri `ts1_kullanicilar`
--
ALTER TABLE `ts1_kullanicilar`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- Tablo için AUTO_INCREMENT değeri `ts1_medyalar`
--
ALTER TABLE `ts1_medyalar`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

--
-- Tablo için AUTO_INCREMENT değeri `ts1_musteriler`
--
ALTER TABLE `ts1_musteriler`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

--
-- Tablo için AUTO_INCREMENT değeri `ts1_tahsilatsekilleri`
--
ALTER TABLE `ts1_tahsilatsekilleri`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
