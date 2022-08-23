-- phpMyAdmin SQL Dump
-- version 4.9.7
-- https://www.phpmyadmin.net/
--
-- 主機： localhost:3306
-- 產生時間： 2022 年 08 月 23 日 09:28
-- 伺服器版本： 5.7.39
-- PHP 版本： 7.4.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- 資料庫： `wda2212_calendar`
--

-- --------------------------------------------------------

--
-- 資料表結構 `notes`
--

CREATE TABLE `wp_calendar_notes` (
  `id` int(11) NOT NULL,
  `note_id` varchar(12) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `note_color` int(11) NOT NULL,
  `note_text` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- 傾印資料表的資料 `notes`
--

INSERT INTO `wp_calendar_notes` (`id`, `note_id`, `note_color`, `note_text`) VALUES
(98, '720228', 2, '父親節'),
(99, '8202228', 5, '123'),
(100, '720221', 5, '今天沒事吃飽\n今天吃飽沒事'),
(102, '7202219', 3, '我生日耶！！\n生日快樂哦哦哦哦哦'),
(103, '7202220', 4, '吃飯吃起來\n好讚好讚'),
(104, '720229', 4, '今天'),
(106, '7202210', 4, '哈囉你好嗎');

--
-- 已傾印資料表的索引
--

--
-- 資料表索引 `notes`
--
ALTER TABLE `wp_calendar_notes`
  ADD PRIMARY KEY (`id`);

--
-- 在傾印的資料表使用自動遞增(AUTO_INCREMENT)
--

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `notes`
--
ALTER TABLE `wp_calendar_notes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=109;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
