-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- ホスト: localhost
-- 生成日時: 2021 年 11 月 08 日 12:27
-- サーバのバージョン： 5.7.32
-- PHP のバージョン: 7.4.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- データベース: `TBMSystem`
--

-- --------------------------------------------------------

--
-- テーブルの構造 `groups`
--

CREATE TABLE `groups` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `kana` varchar(255) NOT NULL,
  `team_number` int(11) NOT NULL,
  `man` int(11) NOT NULL,
  `woman` int(11) NOT NULL,
  `tel` varchar(255) NOT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT NULL,
  `users_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- テーブルのデータのダンプ `groups`
--

INSERT INTO `groups` (`id`, `name`, `kana`, `team_number`, `man`, `woman`, `tel`, `created_at`, `updated_at`, `users_id`) VALUES
(23, 'ねもちゃんず', 'ネモチャンズ', 11, 10, 1, '09047463883', '2021-11-03 11:24:50', NULL, 12),
(24, '横浜BB', 'ヨコハマベースボール', 14, 12, 2, '09047463883', '2021-11-03 13:05:39', NULL, 12),
(25, '東海オンエア', 'トウカイオンエア', 6, 6, 0, '09085938580', '2021-11-05 14:29:27', NULL, 12);

-- --------------------------------------------------------

--
-- テーブルの構造 `players`
--

CREATE TABLE `players` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `kana` varchar(255) NOT NULL,
  `age` int(11) NOT NULL,
  `team_name` varchar(255) NOT NULL,
  `sex` int(11) NOT NULL DEFAULT '0' COMMENT '男：0、女：1',
  `tel` varchar(255) NOT NULL,
  `creatd_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `users_id` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- テーブルのデータのダンプ `players`
--

INSERT INTO `players` (`id`, `name`, `kana`, `age`, `team_name`, `sex`, `tel`, `creatd_at`, `updated_at`, `users_id`) VALUES
(43, '横浜　太郎', 'ヨコハマ　タロウ', 33, 'TTHS', 0, '09047463883', '2021-11-03 11:46:11', '2021-11-05 14:26:45', '12'),
(44, '山田太郎', 'ヤマダタロウ', 24, 'ねもちゃんず', 0, '09083378617', '2021-11-03 11:48:35', '2021-11-03 11:49:41', '12'),
(45, '山田　花太郎', 'ヤマダ　ハナタロウ', 27, '山田太朗ズ', 0, '09047463883', '2021-11-03 11:53:55', NULL, '12'),
(46, '市川弘太郎', 'イチカワコウタロウ', 33, '亀井チャレンジ', 0, '09085938580', '2021-11-03 11:55:44', NULL, '12'),
(47, '緑屋　出久', 'ミドリヤ　イズク', 16, 'アカデミア', 0, '09085938580', '2021-11-03 11:56:54', NULL, '12'),
(48, '山本　武', 'ヤマモト　タケシ', 24, 'ザ・ノーマル', 0, '09085938580', '2021-11-03 11:58:52', NULL, '12'),
(49, '杭全　夢丸', 'クイタ　ユメマル', 29, '東海オンエア', 0, '09047463883', '2021-11-03 13:40:03', NULL, '12'),
(50, '金沢　大樹', 'カナザワタイキ', 31, '東海オンエア', 0, '09047463883', '2021-11-03 13:41:04', NULL, '12'),
(51, '福尾涼', 'フクオリョウ', 29, '東海オンエア', 0, '09047463883', '2021-11-03 13:41:43', NULL, '12'),
(52, '柴田　祐介', 'シバタ　ユウスケ', 29, '東海オンエア', 0, '09047463883', '2021-11-03 13:42:26', NULL, '12'),
(54, '佐藤　健', 'サトウ　タケル', 33, '.ZERO', 0, '09085938580', '2021-11-05 14:27:48', NULL, '12'),
(55, '山田太郎', 'ヤマダタロウ', 29, '東海スター', 0, '09085938580', '2021-11-05 14:28:21', NULL, '12'),
(56, '山田花子', 'ヤマダハナコ', 24, '山田太朗ズ', 1, '09047463883', '2021-11-05 14:28:52', NULL, '12');

-- --------------------------------------------------------

--
-- テーブルの構造 `tournament`
--

CREATE TABLE `tournament` (
  `id` int(11) NOT NULL,
  `tournament_name` varchar(255) NOT NULL,
  `date_time` datetime NOT NULL,
  `field` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `sports_name` varchar(255) NOT NULL,
  `licence` varchar(255) NOT NULL,
  `expense` int(11) NOT NULL,
  `tel` varchar(255) NOT NULL,
  `mail` varchar(255) NOT NULL,
  `limit_datetime` datetime NOT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- テーブルのデータのダンプ `tournament`
--

INSERT INTO `tournament` (`id`, `tournament_name`, `date_time`, `field`, `address`, `sports_name`, `licence`, `expense`, `tel`, `mail`, `limit_datetime`, `created_at`, `updated_at`) VALUES
(32, '横浜市民卓球大会', '2021-11-27 10:00:00', '青葉台スポーツセンター', '神奈川県横浜市青葉区市ケ尾町３１−４', '卓球　個人戦', '横浜市在住、在勤', 1000, '09085938580', 'tune@yahoo.co.jp', '2021-11-13 11:59:00', '2021-11-03 10:54:06', '2021-11-03 11:16:59'),
(33, '全日本卓球選手権神奈川県予選', '2021-11-27 10:00:00', '横浜市中スポーツセンター', '神奈川県横浜市中区新山下３−１５−４', '卓球　個人戦', '横浜市在住、在勤', 1500, '09085938580', 'tune@yahoo.co.jp', '2021-11-27 11:59:00', '2021-11-03 10:56:24', '2021-11-03 11:21:20'),
(34, '横浜市草野球大会', '2021-11-13 10:00:00', '横浜商科大学　野球場', ' 神奈川県横浜市緑区西八朔町７６１', '野球', '横浜市在住、在勤', 1000, '09047463883', 'tunefirm@yahoo.co.jp', '2021-11-13 11:59:00', '2021-11-03 10:58:38', '2021-11-03 11:59:44'),
(35, '横浜レディースオープン卓球大会（Ｗ）', '2021-11-23 09:00:00', '金沢スポーツセンター', '神奈川県横浜市金沢区長浜１０６−８', '卓球　個人戦', '横浜市在住、在勤の女性', 1000, '09047463883', 'tune@yahoo.co.jp', '2021-11-23 11:59:00', '2021-11-03 11:02:39', '2021-11-03 11:14:34'),
(36, '横浜市民スポーツ卓球大会（Ｔ）', '2021-12-19 09:00:00', '戸塚スポーツセンター', '神奈川県横浜市戸塚区上倉田町４７７', '卓球　団体戦', '横浜市在住、在勤', 1000, '09085938580', 'tune@yahoo.co.jp', '2021-12-19 11:59:00', '2021-11-03 11:04:22', '2021-11-03 11:14:47'),
(37, '全横浜少年卓球大会', '2021-12-28 09:00:00', '横浜武道館', '神奈川県横浜市中区翁町２丁目９−１０', '卓球', '横浜市内に在校の小学生以下', 1000, '09085938580', 'tune@yahoo.co.jp', '2021-11-27 23:59:00', '2021-11-03 11:06:25', NULL),
(38, '横浜男女別ペアチーム卓球大会', '2021-11-20 09:00:00', '横浜武道館', '神奈川県横浜市中区翁町２丁目９−１０', '卓球', '横浜市在住、在勤の6〜8人のチーム', 1000, '09085938580', 'tune@yahoo.co.jp', '2021-11-12 23:59:00', '2021-11-03 11:09:11', NULL),
(39, '横浜ニッタク杯（ダブルス）', '2021-11-27 09:00:00', '戸塚スポーツセンター', '神奈川県横浜市戸塚区上倉田町４７７', '卓球', '横浜市在住、在勤', 1000, '09085938580', 'tune@yahoo.co.jp', '2021-11-13 23:59:00', '2021-11-03 11:10:49', NULL),
(40, '横浜オープン２０２２', '2021-11-27 09:00:00', '横浜武道館', '神奈川県横浜市中区翁町２丁目９−１０', '卓球', '横浜市在住、在勤', 1000, '09047463883', 'tune@yahoo.co.jp', '2021-11-13 23:59:00', '2021-11-03 11:11:53', NULL),
(41, '高校学年別卓球大会', '2021-11-27 09:00:00', '戸塚スポーツセンター', '神奈川県横浜市戸塚区上倉田町４７７', '卓球', '横浜市内の高校に在籍', 1000, '09085938580', 'tune@yahoo.co.jp', '2021-11-13 23:00:00', '2021-11-03 11:13:18', NULL);

-- --------------------------------------------------------

--
-- テーブルの構造 `tournament_group`
--

CREATE TABLE `tournament_group` (
  `id` int(11) NOT NULL,
  `group_id` int(11) NOT NULL,
  `tournament_id` int(11) NOT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `update_at` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- テーブルのデータのダンプ `tournament_group`
--

INSERT INTO `tournament_group` (`id`, `group_id`, `tournament_id`, `created_at`, `update_at`) VALUES
(28, 23, 34, '2021-11-03 11:24:50', NULL),
(29, 24, 34, '2021-11-03 13:05:39', NULL),
(30, 25, 41, '2021-11-05 14:29:27', NULL);

-- --------------------------------------------------------

--
-- テーブルの構造 `tournament_player`
--

CREATE TABLE `tournament_player` (
  `id` int(11) NOT NULL,
  `player_id` int(11) NOT NULL,
  `tournament_id` int(11) NOT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `update_at` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- テーブルのデータのダンプ `tournament_player`
--

INSERT INTO `tournament_player` (`id`, `player_id`, `tournament_id`, `created_at`, `update_at`) VALUES
(35, 41, 32, '2021-11-03 11:22:07', NULL),
(37, 43, 41, '2021-11-03 11:46:11', NULL),
(38, 44, 33, '2021-11-03 11:48:35', NULL),
(39, 45, 32, '2021-11-03 11:53:55', NULL),
(40, 46, 32, '2021-11-03 11:55:44', NULL),
(41, 47, 32, '2021-11-03 11:56:54', NULL),
(42, 48, 32, '2021-11-03 11:58:52', NULL),
(43, 49, 32, '2021-11-03 13:40:03', NULL),
(44, 50, 32, '2021-11-03 13:41:04', NULL),
(45, 51, 32, '2021-11-03 13:41:43', NULL),
(46, 52, 32, '2021-11-03 13:42:26', NULL),
(47, 53, 41, '2021-11-05 14:26:18', NULL),
(48, 54, 41, '2021-11-05 14:27:48', NULL),
(49, 55, 41, '2021-11-05 14:28:21', NULL),
(50, 56, 41, '2021-11-05 14:28:52', NULL);

-- --------------------------------------------------------

--
-- テーブルの構造 `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `mail` varchar(255) NOT NULL,
  `password` varchar(100) NOT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `role` int(2) DEFAULT '0' COMMENT '一般ユーザ：1、管理ユーザ：0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- テーブルのデータのダンプ `users`
--

INSERT INTO `users` (`id`, `name`, `mail`, `password`, `created_at`, `updated_at`, `role`) VALUES
(13, 'sample', 'sample@gmail.com', '$2y$10$1d./ixC7VmHdZ7PhOeyLUe0iLUMEPhPCZwV6GhA2SGflhVGRxlqXe', '2021-11-08 21:24:12', NULL, 0),
(14, '管理者', 'admin@gmail.com', '$2y$10$IVJbUDuQrZcynzpj/tgSXOaLX8TN/4gaPAr2ogLNb5NS1mRLwr3H2', '2021-11-08 21:25:36', '2021-11-08 21:26:12', 1);

--
-- ダンプしたテーブルのインデックス
--

--
-- テーブルのインデックス `groups`
--
ALTER TABLE `groups`
  ADD PRIMARY KEY (`id`);

--
-- テーブルのインデックス `players`
--
ALTER TABLE `players`
  ADD PRIMARY KEY (`id`);

--
-- テーブルのインデックス `tournament`
--
ALTER TABLE `tournament`
  ADD PRIMARY KEY (`id`);

--
-- テーブルのインデックス `tournament_group`
--
ALTER TABLE `tournament_group`
  ADD PRIMARY KEY (`id`);

--
-- テーブルのインデックス `tournament_player`
--
ALTER TABLE `tournament_player`
  ADD PRIMARY KEY (`id`);

--
-- テーブルのインデックス `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- ダンプしたテーブルの AUTO_INCREMENT
--

--
-- テーブルの AUTO_INCREMENT `groups`
--
ALTER TABLE `groups`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- テーブルの AUTO_INCREMENT `players`
--
ALTER TABLE `players`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=57;

--
-- テーブルの AUTO_INCREMENT `tournament`
--
ALTER TABLE `tournament`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- テーブルの AUTO_INCREMENT `tournament_group`
--
ALTER TABLE `tournament_group`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- テーブルの AUTO_INCREMENT `tournament_player`
--
ALTER TABLE `tournament_player`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- テーブルの AUTO_INCREMENT `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
