-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 31, 2024 at 12:12 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `giyim`
--

-- --------------------------------------------------------

--
-- Table structure for table `favoriler`
--

CREATE TABLE `favoriler` (
  `favori_id` int(11) NOT NULL,
  `favori_kullanici` int(11) NOT NULL,
  `favori_urun` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_turkish_ci;

--
-- Dumping data for table `favoriler`
--

INSERT INTO `favoriler` (`favori_id`, `favori_kullanici`, `favori_urun`) VALUES
(12, 1, 1),
(5, 2, 1),
(8, 3, 1),
(11, 7, 4);

-- --------------------------------------------------------

--
-- Table structure for table `kullanicilar`
--

CREATE TABLE `kullanicilar` (
  `kullanici_id` int(11) NOT NULL,
  `kullanici_mail` varchar(64) NOT NULL,
  `kullanici_sifre` varchar(16) NOT NULL,
  `kullanici_isim` varchar(24) NOT NULL,
  `kullanici_kayit` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_turkish_ci;

--
-- Dumping data for table `kullanicilar`
--

INSERT INTO `kullanicilar` (`kullanici_id`, `kullanici_mail`, `kullanici_sifre`, `kullanici_isim`, `kullanici_kayit`) VALUES
(1, 'admin@mail.com', 'Admin123', 'Admin', 1703421983),
(7, 'kamilurer1@gmail.com', 'asd12345', 'Kamil Urer', 1717147906);

-- --------------------------------------------------------

--
-- Table structure for table `mesajlar`
--

CREATE TABLE `mesajlar` (
  `mesaj_id` int(11) NOT NULL,
  `mesaj_ad` varchar(24) NOT NULL,
  `mesaj_mail` varchar(128) NOT NULL,
  `mesaj_icerik` text NOT NULL,
  `mesaj_tarih` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_turkish_ci;

--
-- Dumping data for table `mesajlar`
--

INSERT INTO `mesajlar` (`mesaj_id`, `mesaj_ad`, `mesaj_mail`, `mesaj_icerik`, `mesaj_tarih`) VALUES
(4, 'Merhaba', 'alskdjhgtasydhukqw@gmail.com', 'deneme', 1717147864),
(3, 'Merhaba', 'admin@admin.com', 'Deneme mesajı', 1717136049);

-- --------------------------------------------------------

--
-- Table structure for table `urunler`
--

CREATE TABLE `urunler` (
  `urun_id` int(11) NOT NULL,
  `urun_isim` varchar(255) NOT NULL,
  `urun_kategori` varchar(255) NOT NULL,
  `urun_fiyat` int(11) NOT NULL,
  `urun_renk` varchar(255) NOT NULL,
  `urun_stok` int(11) NOT NULL,
  `populer` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_turkish_ci;

--
-- Dumping data for table `urunler`
--

INSERT INTO `urunler` (`urun_id`, `urun_isim`, `urun_kategori`, `urun_fiyat`, `urun_renk`, `urun_stok`, `populer`) VALUES
(1, 'XL Kendrick Album Cover T-Shirt', 'Erkek', 600, 'Beyaz', 200, 1),
(4, 'S Beden Kadın T-Shirt', 'Kadın', 845, 'Siyah', 300, 1),
(5, 'M Beden Rap Album T-Shirt', 'Erkek', 1000, 'Siyah', 200, 1),
(6, 'M Beden Erkek Baskılı Deri Ceket', 'Erkek', 2500, 'Siyah', 50, 0),
(7, 'Beyaz Oversize Kısa Kollu T-Shirt', 'Kadın', 400, 'Beyaz', 200, 0),
(8, 'Kadın T-Shirt', 'Kadın', 700, 'Yeşil', 200, 0),
(9, 'Album Kapağı T-Shirt', 'Erkek', 555, 'Siyah', 200, 0),
(10, 'Yeni Doğan Bebek Kıyafeti', 'Çocuk', 500, 'Beyaz', 200, 0),
(11, 'Kendrick Album Cover T-Shirt', 'Erkek', 1200, 'Siyah', 255, 1),
(15, 'Deneme', 'Erkek', 555, 'Beyaz', 200, 1),
(16, 'Rap Album T-Shirt', 'Erkek', 500, 'Kahverengi', 200, 0);

-- --------------------------------------------------------

--
-- Table structure for table `yorumlar`
--

CREATE TABLE `yorumlar` (
  `yorum_id` int(11) NOT NULL,
  `yorum_urunid` int(11) NOT NULL,
  `yorum_kullanici_id` int(11) NOT NULL,
  `yorum_icerik` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_turkish_ci;

--
-- Dumping data for table `yorumlar`
--

INSERT INTO `yorumlar` (`yorum_id`, `yorum_urunid`, `yorum_kullanici_id`, `yorum_icerik`) VALUES
(1, 2, 1, 'dasdsadasdasd'),
(9, 6, 1, 'Begendim, gayet güzel kumaş!'),
(13, 1, 1, 'Mükemmel Ürün'),
(14, 4, 1, 'Kaliteli ürün. teşekkürler');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `favoriler`
--
ALTER TABLE `favoriler`
  ADD PRIMARY KEY (`favori_id`);

--
-- Indexes for table `kullanicilar`
--
ALTER TABLE `kullanicilar`
  ADD PRIMARY KEY (`kullanici_id`);

--
-- Indexes for table `mesajlar`
--
ALTER TABLE `mesajlar`
  ADD PRIMARY KEY (`mesaj_id`);

--
-- Indexes for table `urunler`
--
ALTER TABLE `urunler`
  ADD PRIMARY KEY (`urun_id`);

--
-- Indexes for table `yorumlar`
--
ALTER TABLE `yorumlar`
  ADD PRIMARY KEY (`yorum_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `favoriler`
--
ALTER TABLE `favoriler`
  MODIFY `favori_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `kullanicilar`
--
ALTER TABLE `kullanicilar`
  MODIFY `kullanici_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `mesajlar`
--
ALTER TABLE `mesajlar`
  MODIFY `mesaj_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `urunler`
--
ALTER TABLE `urunler`
  MODIFY `urun_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `yorumlar`
--
ALTER TABLE `yorumlar`
  MODIFY `yorum_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
