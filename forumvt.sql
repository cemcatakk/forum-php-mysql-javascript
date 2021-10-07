

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


CREATE DATABASE IF NOT EXISTS `forumvt` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `forumvt`;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `konu`
--

CREATE TABLE `konu` (
  `id` int(11) NOT NULL,
  `baslik` varchar(100) NOT NULL,
  `konuadi` varchar(100) NOT NULL,
  `olusturanid` int(11) NOT NULL,
  `olusturmatarihi` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Tablo döküm verisi `konu`
--

INSERT INTO `konu` (`id`, `baslik`, `konuadi`, `olusturanid`, `olusturmatarihi`) VALUES
(10, 'Teknoloji', 'Teknoloji hakkında herşey', 1, '2021-04-16'),
(11, 'Bilim', 'Son durumlar', 1, '2021-04-16'),
(12, 'İletişim', 'İletişim çağı hakkında', 1, '2021-04-16');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `konuyorum`
--

CREATE TABLE `konuyorum` (
  `id` int(11) NOT NULL,
  `konuid` int(11) NOT NULL,
  `kullaniciid` int(11) NOT NULL,
  `yorum` varchar(500) NOT NULL,
  `tarih` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Tablo döküm verisi `konuyorum`
--

INSERT INTO `konuyorum` (`id`, `konuid`, `kullaniciid`, `yorum`, `tarih`) VALUES
(3, 5, 1, 'test', '2021-04-16'),
(4, 5, 1, 'wqewq', '2021-04-16'),
(6, 10, 1, 'Görüşleriniz neler?', '2021-04-16'),
(7, 10, 6, 'Güzel başlık..\r\n', '2021-04-16');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `kullanici`
--

CREATE TABLE `kullanici` (
  `id` int(11) NOT NULL,
  `kullaniciadi` varchar(100) NOT NULL,
  `sifre` varchar(100) NOT NULL,
  `eposta` varchar(100) NOT NULL,
  `yetki` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Tablo döküm verisi `kullanici`
--

INSERT INTO `kullanici` (`id`, `kullaniciadi`, `sifre`, `eposta`, `yetki`) VALUES
(1, 'admin', 'password', 'admin', 1),
(2, 'asdsad', 'qweqwe', 'asdsad', 0),
(6, 'mehmetkara', 'mehmetkara', 'mehmetkara@gmail.com', 0);

--
-- Dökümü yapılmış tablolar için indeksler
--

--
-- Tablo için indeksler `konu`
--
ALTER TABLE `konu`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `konuyorum`
--
ALTER TABLE `konuyorum`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `kullanici`
--
ALTER TABLE `kullanici`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `kullaniciadi` (`kullaniciadi`,`eposta`);

--
-- Dökümü yapılmış tablolar için AUTO_INCREMENT değeri
--

--
-- Tablo için AUTO_INCREMENT değeri `konu`
--
ALTER TABLE `konu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- Tablo için AUTO_INCREMENT değeri `konuyorum`
--
ALTER TABLE `konuyorum`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Tablo için AUTO_INCREMENT değeri `kullanici`
--
ALTER TABLE `kullanici`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
