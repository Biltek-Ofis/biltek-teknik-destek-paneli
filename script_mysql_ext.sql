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

DELIMITER $$
--
-- İşlevler
--
CREATE FUNCTION `ozelIDOlustur` (`isim` VARCHAR(50), `grup` VARCHAR(10)) RETURNS VARCHAR(20) CHARSET utf8  BEGIN
    DECLARE son_val INT; 
 
    SET son_val =  (SELECT id_val
                          FROM ozelid
                          WHERE id_adi = isim
                                AND id_grup = grup);
    IF son_val IS NULL THEN
        SET son_val = 1;
        INSERT INTO ozelid (id_adi,id_grup,id_val)
        VALUES (isim,grup,son_val);
    ELSE
        SET son_val = son_val + 1;
        UPDATE ozelid SET id_val = son_val
        WHERE id_adi = isim AND id_grup = grup;
    END IF; 
 
    SET @ret = (SELECT concat(grup,lpad(son_val,6,'0')));
    RETURN @ret;
END$$

DELIMITER ;


--
-- Tetikleyiciler `cihazlar`
--
DELIMITER $$
CREATE TRIGGER `BeforeDeletedCihazlar` BEFORE DELETE ON `cihazlar` FOR EACH ROW INSERT INTO silinencihazlar(id)
VALUES(OLD.id)
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `BeforeInsertCihazlar` BEFORE INSERT ON `cihazlar` FOR EACH ROW SET NEW.servis_no = ozelIDOlustur(year(now()),year(now()))
$$
DELIMITER ;

DELIMITER $$
--
-- Olaylar
--
CREATE EVENT `SilinenCihazlariTemizle` ON SCHEDULE EVERY 1 DAY STARTS '2022-08-29 10:30:00' ON COMPLETION NOT PRESERVE ENABLE DO Delete from silinencihazlar WHERE silinme_tarihi < now() - interval 1 day$$

DELIMITER ;
COMMIT;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;