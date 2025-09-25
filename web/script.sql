-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Anamakine: 127.0.0.1
-- Üretim Zamanı: 31 May 2025, 16:40:47
-- Sunucu sürümü: 10.4.27-MariaDB
-- PHP Sürümü: 7.4.33

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
-- Tablo için tablo yapısı `ts1_ayarlar`
--

CREATE TABLE `ts1_ayarlar` (
  `id` int(11) NOT NULL,
  `site_basligi` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `firma_url` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `sirket_unvani` varchar(255) DEFAULT '',
  `adres` text NOT NULL,
  `sirket_telefonu` varchar(255) NOT NULL,
  `tablo_oge` int(11) NOT NULL,
  `barkod_ad` varchar(255) NOT NULL DEFAULT '',
  `barkod_en` int(11) NOT NULL,
  `barkod_boy` int(11) NOT NULL,
  `barkod_boyutu` int(11) NOT NULL,
  `barkod_numarasi_boyutu` int(11) NOT NULL,
  `barkod_musteri_adi_boyutu` int(11) NOT NULL,
  `barkod_sirket_adi_boyutu` int(11) NOT NULL,
  `app_version` varchar(10) NOT NULL DEFAULT '0.0.1',
  `biltekdesk_url` TEXT NOT NULL,
  `kis_modu` tinyint(4) NOT NULL DEFAULT 0,
  `tema` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci;

--
-- Tablo döküm verisi `ts1_ayarlar`
--

INSERT INTO `ts1_ayarlar` (`id`, `site_basligi`, `firma_url`, `sirket_unvani`, `adres`, `sirket_telefonu`, `tablo_oge`, `barkod_ad`, `barkod_en`, `barkod_boy`, `barkod_boyutu`, `barkod_numarasi_boyutu`, `barkod_musteri_adi_boyutu`, `barkod_sirket_adi_boyutu`, `app_version`, `biltekdesk_url`, `kis_modu`, `tema`) VALUES
(1, 'Biltek Bilgisayar Teknik Servis', 'http://www.biltekbilgisayar.com.tr/', 'BİLTEK OFİS ve BİLİŞİM SİSTEMLERİ SAN. TİC. LTD. ŞTİ.', 'Güzelhisar Mahallesi, Yedi Eylül Caddesi, No: 16/A, Efeler/AYDIN', '+90 (544) 397-0992', 50, 'Biltek Bilgisayar', 40, 20, 14, 12, 12, 10, '114', '', 1, 1);


-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `ts1_cagri_kayitlari`
--

CREATE TABLE `ts1_cagri_kayitlari` (
  `id` int(11) NOT NULL,
  `kull_id` int(11) NOT NULL,
  `bolge` varchar(255) NOT NULL DEFAULT '',
  `birim` varchar(255) NOT NULL DEFAULT '',
  `telefon_numarasi` VARCHAR(255) NOT NULL DEFAULT '',
  `cihaz_turu` int(11) NOT NULL,
  `cihaz` varchar(255) NOT NULL,
  `cihaz_modeli` varchar(255) NOT NULL,
  `seri_no` varchar(255) NOT NULL,
  `ariza_aciklamasi` longtext NOT NULL,
  `tarih` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `ts1_cihazdurumlari`
--

CREATE TABLE `ts1_cihazdurumlari` (
  `id` int(11) NOT NULL,
  `siralama` int(11) NOT NULL,
  `durum` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `renk` varchar(255) NOT NULL,
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
(4, 8, 'CASPER  (GARANTİLİ) Merkez Servise Gönderildi', 'bg-pink', 0, 0),
(5, 4, 'Fiyat Onayı Bekleniyor', 'bg-warning', 0, 0),
(6, 9, 'Fiyat Onaylandı', 'bg-primary', 0, 0),
(7, 15, 'Fiyat Onaylanmadı', 'bg-danger', 0, 0),
(8, 16, 'İade Edildi', 'bg-danger', 0, 0),
(9, 6, 'Teslim Edilmeye Hazır', 'bg-primary', 0, 0),
(10, 11, 'Teslim Edildi / Ödeme Alınmadı', 'bg-danger', 0, 0),
(11, 13, 'Teslim Edildi', 'bg-success', 1, 0),
(12, 10, 'Garantisiz DIŞ Servise Gönderildi', 'bg-pink', 0, 0),
(13, 14, 'iade Edilecek', 'bg-white', 0, 0),
(14, 12, 'Teslim Edildi / Garantili Cihaz (Ücretsiz)', 'bg-success', 1, 0),
(15, 7, 'Teslim Edilmeye Hazır / Müşteri Arandı', 'bg-primary', 0, 0),
(16, 5, 'Fiyat Onaylandı / Yedek Parça Sipariş Edilecek ', 'bg-primary', 0, 0),
(17, 17, 'MAKİNE KURULUMU', 'bg-white', 0, 0);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `ts1_cihazlar`
--

CREATE TABLE `ts1_cihazlar` (
  `id` int(11) NOT NULL,
  `servis_no` varchar(50) DEFAULT NULL,
  `takip_numarasi` int(11) NOT NULL,
  `cagri_id` INT NOT NULL DEFAULT '0', 
  `kull_id` INT NOT NULL DEFAULT '0',
  `musteri_kod` int(11) DEFAULT NULL,
  `musteri_adi` varchar(255) NOT NULL,
  `teslim_eden` varchar(255) NOT NULL DEFAULT '',
  `teslim_alan` varchar(255) NOT NULL DEFAULT '',
  `adres` varchar(255) NOT NULL,
  `telefon_numarasi` varchar(255) NOT NULL,
  `cihaz_turu` int(11) NOT NULL,
  `sorumlu` int(11) NOT NULL DEFAULT 0,
  `cihaz` varchar(255) NOT NULL,
  `cihaz_modeli` varchar(255) NOT NULL,
  `seri_no` varchar(255) NOT NULL,
  `cihaz_sifresi` varchar(50) DEFAULT NULL,
  `cihaz_deseni` varchar(100) NOT NULL DEFAULT '',
  `cihaz_deseni_actives` varchar(100) NOT NULL DEFAULT '',
  `cihaz_deseni_lines` varchar(100) NOT NULL DEFAULT '',
  `hasar_tespiti` varchar(255) NOT NULL,
  `cihazdaki_hasar` int(11) NOT NULL,
  `ariza_aciklamasi` longtext DEFAULT NULL,
  `servis_turu` int(11) NOT NULL,
  `yedek_durumu` int(11) NOT NULL,
  `teslim_alinanlar` longtext DEFAULT NULL,
  `yapilan_islem_aciklamasi` longtext DEFAULT NULL,
  `notlar` longtext NOT NULL,
  `teslim_edildi` int(11) NOT NULL DEFAULT 0,
  `tarih` datetime NOT NULL DEFAULT current_timestamp(),
  `bildirim_tarihi` datetime DEFAULT NULL,
  `cikis_tarihi` datetime DEFAULT NULL,
  `guncel_durum` int(11) NOT NULL DEFAULT 1,
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `ts1_cihazturleri`
--

CREATE TABLE `ts1_cihazturleri` (
  `id` int(11) NOT NULL,
  `siralama` int(11) NOT NULL DEFAULT 0,
  `isim` varchar(255) NOT NULL,
  `sifre` tinyint(3) UNSIGNED NOT NULL DEFAULT 0,
  `goster` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Tablo döküm verisi `ts1_cihazturleri`
--

INSERT INTO `ts1_cihazturleri` (`id`, `siralama`, `isim`, `sifre`, `goster`) VALUES
(1, 12, 'Bilgisayar', 1, 1),
(2, 11, 'Tablet - Telefon', 1, 0),
(3, 8, 'Yazıcı', 0, 1),
(4, 6, 'Çevre Birimleri', 0, 1),
(5, 5, 'Toner/Sarf Malzeme Teslimi', 0, 1),
(6, 10, 'Telefon', 1, 1),
(7, 9, 'Tablet', 1, 1),
(8, 7, 'Tarayıcı', 0, 1),
(9, 0, 'Genel Bakım Servis', 0, 1);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `ts1_cihaz_ac`
--

CREATE TABLE `ts1_cihaz_ac` (
  `id` int(11) NOT NULL,
  `kullanici_id` int(11) NOT NULL,
  `servis_no` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Tablo döküm verisi `ts1_cihaz_ac`
--

INSERT INTO `ts1_cihaz_ac` (`id`, `kullanici_id`, `servis_no`) VALUES
(44, 0, 2025000393);
-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `ts1_guncelleme`
--

CREATE TABLE `ts1_guncelleme` (
  `id` int(11) NOT NULL,
  `guncelleme_tarihi` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Tablo döküm verisi `ts1_guncelleme`
--

INSERT INTO `ts1_guncelleme` (`id`, `guncelleme_tarihi`) VALUES
(1, 1748700159);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `ts1_islemler`
--

CREATE TABLE `ts1_islemler` (
  `id` int(11) NOT NULL,
  `cihaz_id` int(11) NOT NULL,
  `islem_sayisi` int(1) NOT NULL,
  `ad` varchar(255) NOT NULL,
  `maliyet` decimal(28,2) NOT NULL DEFAULT 0.00,
  `birim_fiyat` decimal(28,2) NOT NULL DEFAULT 0.00,
  `miktar` int(11) NOT NULL DEFAULT 0,
  `kdv` decimal(5,2) NOT NULL DEFAULT 0.00
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `ts1_kullanicilar`
--

CREATE TABLE `ts1_kullanicilar` (
  `id` int(11) NOT NULL,
  `kullanici_adi` varchar(50) DEFAULT NULL,
  `ad_soyad` varchar(100) DEFAULT NULL,
  `sifre` varchar(255) NOT NULL,
  `urunduzenleme` int(1) NOT NULL DEFAULT 0,
  `teknikservis` int(1) NOT NULL DEFAULT 0,
  `yonetici` int(1) NOT NULL DEFAULT 0,
  `musteri` int(1) NOT NULL DEFAULT 0,
  `tema` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Tablo döküm verisi `ts1_kullanicilar`
--

INSERT INTO `ts1_kullanicilar` (`id`, `kullanici_adi`, `ad_soyad`, `sifre`, `urunduzenleme`, `teknikservis`, `yonetici`, `tema`) VALUES
(3, 'HUSNU', 'Hüsnü SÖZÜTOK', '$2y$10$sSaswokEL5GoLaKg8N.64.o6lzhwzaMlOAZn.478jVMC/EqfCthEu', 1, 1, 0, 0),
(5, 'ISILTAN', 'Işıltan KÜÇÜKKAYA', '$2y$10$ziTZg6lOAQt2I8WzEc2CG.IW3tIawb388KaX0X6.1U5sthjReF1XC', 0, 1, 0, 0),
(9, 'RUKIYE', 'Rukiye AKTÜRK', '$2y$10$LgO1yUTHOF.EZXiYtevp6OFloW0ZkRsJJMvNSVO.Hy1SYFVfnM9qe', 0, 0, 1, 0),
(12, 'OZAY', 'Özay AKCAN', '$2y$10$l8YCw.d56otWDtcTL1z9KuUTdWb6lbQ1vz4m1yfvnPcJWcJ3QTHfW', 0, 0, 1, 0),
(13, 'YUKSEL', 'YÜKSEL GÜMÜŞ', '$2y$10$9CUynqZ5p4qdBBqNaVd.k..mLriP5Plf.AmRb2sx8AFGnzQ07e.wi', 0, 1, 0, 0);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `ts1_kullanici_auth`
--

CREATE TABLE `ts1_kullanici_auth` (
  `id` int(11) NOT NULL,
  `kullanici_id` int(11) NOT NULL,
  `auth` varchar(50) NOT NULL,
  `fcmToken` varchar(255) NOT NULL DEFAULT '',
  `cihazID` varchar(255) NOT NULL DEFAULT '',
  `bitis` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `ts1_kullanici_bildirimleri`
--

CREATE TABLE `ts1_kullanici_bildirimleri` (
  `id` int(11) NOT NULL,
  `kullanici_id` int(11) NOT NULL,
  `bildirim_turu` varchar(255) NOT NULL,
  `durum` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci;

-- --------------------------------------------------------
--
-- Tablo için tablo yapısı `ts1_loglar`
--

CREATE TABLE `ts1_loglar` (
  `id` int(11) NOT NULL,
  `cihaz_id` int(11) NOT NULL,
  `aciklama` text NOT NULL,
  `tarih` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP;
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `ts1_malzeme_teslimi`
--

CREATE TABLE `ts1_malzeme_teslimi` (
  `id` int(11) NOT NULL,
  `teslim_no` varchar(11) NOT NULL,
  `firma` varchar(255) NOT NULL,
  `siparis_tarihi` date NOT NULL,
  `teslim_tarihi` date NOT NULL,
  `vade_tarihi` date NOT NULL,
  `teslim_eden` varchar(255) NOT NULL,
  `teslim_alan` varchar(255) NOT NULL,
  `odeme_durumu` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `ts1_malzeme_teslimi_islemler`
--

CREATE TABLE `ts1_malzeme_teslimi_islemler` (
   `id` int(11) NOT NULL,
  `teslim_id` int(11) NOT NULL,
  `islem_sira` int(11) NOT NULL,
  `stok_kodu` varchar(255) NOT NULL DEFAULT '',
  `isim` varchar(255) NOT NULL,
  `birim_fiyati` decimal(28,2) NOT NULL DEFAULT 0.00,
  `adet` int(11) NOT NULL DEFAULT 0,
  `kdv` decimal(28,2) NOT NULL DEFAULT 0.00
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `ts1_malzeme_teslimi_ozelid`
--

CREATE TABLE `ts1_malzeme_teslimi_ozelid` (
  `id_adi` varchar(50) NOT NULL,
  `id_grup` varchar(10) NOT NULL,
  `id_val` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Tablo döküm verisi `ts1_malzeme_teslimi_ozelid`
--

INSERT INTO `ts1_malzeme_teslimi_ozelid` (`id_adi`, `id_grup`, `id_val`) VALUES
('2025', '2025', 1);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `ts1_medyalar`
--

CREATE TABLE `ts1_medyalar` (
  `id` int(11) NOT NULL,
  `cihaz_id` int(11) NOT NULL,
  `konum` varchar(255) NOT NULL,
  `yerel` tinyint(1) NOT NULL DEFAULT 1,
  `tur` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `ts1_musteriler`
--

CREATE TABLE `ts1_musteriler` (
  `id` int(11) NOT NULL,
  `musteri_adi` varchar(255) NOT NULL,
  `adres` varchar(255) NOT NULL,
  `telefon_numarasi` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `ts1_ozelid`
--

CREATE TABLE `ts1_ozelid` (
  `id_adi` varchar(50) NOT NULL,
  `id_grup` varchar(10) NOT NULL,
  `id_val` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Tablo döküm verisi `ts1_ozelid`
--

INSERT INTO `ts1_ozelid` (`id_adi`, `id_grup`, `id_val`) VALUES
('2022', '2022', 638),
('2023', '2023', 1380),
('2024', '2024', 1146),
('2025', '2025', 511);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `ts1_sessions`
--

CREATE TABLE `ts1_sessions` (
  `id` varchar(40) NOT NULL,
  `ip_address` varchar(45) NOT NULL,
  `timestamp` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `data` blob NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `ts1_silinencihazlar`
--

CREATE TABLE `ts1_silinencihazlar` (
  `id` int(11) NOT NULL,
  `silinme_tarihi` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Tablo döküm verisi `ts1_silinencihazlar`
--

INSERT INTO `ts1_silinencihazlar` (`id`, `silinme_tarihi`) VALUES
(3683, '2025-05-27 15:42:07');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `ts1_tahsilatsekilleri`
--

CREATE TABLE `ts1_tahsilatsekilleri` (
  `id` int(11) NOT NULL,
  `isim` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Tablo döküm verisi `ts1_tahsilatsekilleri`
--

INSERT INTO `ts1_tahsilatsekilleri` (`id`, `isim`) VALUES
(1, 'Nakit'),
(2, 'Kredi Kartı'),
(3, 'Mail Order'),
(4, 'Açık Hesap'),
(5, 'Banka Havalesi');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `ts1_temalar`
--

CREATE TABLE `ts1_temalar` (
  `id` int(11) NOT NULL,
  `isim` varchar(255) NOT NULL DEFAULT '',
  `arkaplan` varchar(255) NOT NULL DEFAULT '',
  `yazi_rengi` varchar(255) NOT NULL DEFAULT '',
  `giris_arkaplani` varchar(255) NOT NULL DEFAULT '',
  `beyaz_arkaplan_yazi` varchar(255) NOT NULL DEFAULT '',
  `menu_icon_rengi` varchar(255) NOT NULL DEFAULT '',
  `kar_yagisi` int(1) NOT NULL DEFAULT 0,
  `onizleme_resmi` varchar(255) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `ts1_temalar`
--

INSERT INTO `ts1_temalar` (`id`, `isim`, `arkaplan`, `yazi_rengi`, `giris_arkaplani`, `beyaz_arkaplan_yazi`, `menu_icon_rengi`, `kar_yagisi`, `onizleme_resmi`) VALUES
(1, 'Varsayılan', '', '', '', '', '', 0, 'varsayilan.png'),
(2, 'Kış Modu', 'linear-gradient(#123, #111)', '#ffffff', 'rgba(170, 166, 166, 0.6)', 'black', '255, 255, 255, 1', 1, 'kis.gif');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `ts1_urunler`
--

CREATE TABLE `ts1_urunler` (
  `id` int(11) NOT NULL,
  `isim` varchar(255) NOT NULL,
  `aciklama` text NOT NULL,
  `baglanti` text NOT NULL,
  `stokkodu` varchar(255) NOT NULL,
  `stokadeti` int(11) NOT NULL DEFAULT 0,
  `barkod` varchar(255) NOT NULL,
  `alis` decimal(28,2) NOT NULL DEFAULT 0.00,
  `satis` decimal(28,2) NOT NULL DEFAULT 0.00,
  `indirimli` decimal(28,2) NOT NULL DEFAULT 0.00,
  `kg` decimal(28,2) NOT NULL DEFAULT 0.00
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------
--
-- Dökümü yapılmış tablolar için indeksler
--

--
-- Tablo için indeksler `ts1_ayarlar`
--
ALTER TABLE `ts1_ayarlar`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `ts1_cagri_kayitlari`
--
ALTER TABLE `ts1_cagri_kayitlari`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `ts1_cihazdurumlari`
--
ALTER TABLE `ts1_cihazdurumlari`
  ADD PRIMARY KEY (`id`);

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
-- Tablo için indeksler `ts1_cihaz_ac`
--
ALTER TABLE `ts1_cihaz_ac`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `ts1_formlar`
--
ALTER TABLE `ts1_formlar`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `ts1_form_kullanici_cevaplari`
--
ALTER TABLE `ts1_form_kullanici_cevaplari`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `ts1_form_sorulari`
--
ALTER TABLE `ts1_form_sorulari`
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
-- Tablo için indeksler `ts1_kullanici_auth`
--
ALTER TABLE `ts1_kullanici_auth`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `ts1_kullanici_bildirimleri`
--
ALTER TABLE `ts1_kullanici_bildirimleri`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `ts1_loglar`
--
ALTER TABLE `ts1_loglar`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `ts1_lisanslar`
--
ALTER TABLE `ts1_lisanslar`
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
-- Tablo için indeksler `ts1_sessions`
--
ALTER TABLE `ts1_sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ts1_sessions_timestamp` (`timestamp`);

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
-- Tablo için indeksler `ts1_temalar`
--
ALTER TABLE `ts1_temalar`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `ts1_urunler`
--
ALTER TABLE `ts1_urunler`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `ts1_versiyonlar`
--
ALTER TABLE `ts1_versiyonlar`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `ts1_malzeme_teslimi`
--
ALTER TABLE `ts1_malzeme_teslimi`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `ts1_malzeme_teslimi_islemler`
--
ALTER TABLE `ts1_malzeme_teslimi_islemler`
  ADD PRIMARY KEY (`id`);

--
-- Dökümü yapılmış tablolar için AUTO_INCREMENT değeri
--

--
-- Tablo için AUTO_INCREMENT değeri `ts1_ayarlar`
--
ALTER TABLE `ts1_ayarlar`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Tablo için AUTO_INCREMENT değeri `ts1_cagri_kayitlari`
--
ALTER TABLE `ts1_cagri_kayitlari`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Tablo için AUTO_INCREMENT değeri `ts1_cihazdurumlari`
--
ALTER TABLE `ts1_cihazdurumlari`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- Tablo için AUTO_INCREMENT değeri `ts1_cihazlar`
--
ALTER TABLE `ts1_cihazlar`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

--
-- Tablo için AUTO_INCREMENT değeri `ts1_cihazturleri`
--
ALTER TABLE `ts1_cihazturleri`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Tablo için AUTO_INCREMENT değeri `ts1_cihaz_ac`
--
ALTER TABLE `ts1_cihaz_ac`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

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
-- Tablo için AUTO_INCREMENT değeri `ts1_kullanici_auth`
--
ALTER TABLE `ts1_kullanici_auth`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

--
-- Tablo için AUTO_INCREMENT değeri `ts1_kullanici_bildirimleri`
--
ALTER TABLE `ts1_kullanici_bildirimleri`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Tablo için AUTO_INCREMENT değeri `ts1_loglar`
--
ALTER TABLE `ts1_loglar`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

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

--
-- Tablo için AUTO_INCREMENT değeri `ts1_temalar`
--
ALTER TABLE `ts1_temalar`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Tablo için AUTO_INCREMENT değeri `ts1_urunler`
--
ALTER TABLE `ts1_urunler`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

--
-- Tablo için AUTO_INCREMENT değeri `ts1_malzeme_teslimi`
--
ALTER TABLE `ts1_malzeme_teslimi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

--
-- Tablo için AUTO_INCREMENT değeri `ts1_malzeme_teslimi_islemler`
--
ALTER TABLE `ts1_malzeme_teslimi_islemler`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
