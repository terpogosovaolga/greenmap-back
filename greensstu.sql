-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Фев 10 2023 г., 16:04
-- Версия сервера: 8.0.30
-- Версия PHP: 8.1.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `greensstu`
--

-- --------------------------------------------------------

--
-- Структура таблицы `locations`
--

CREATE TABLE `locations` (
  `id` int NOT NULL,
  `name` varchar(100) NOT NULL,
  `latitude_center` double NOT NULL,
  `longitude_center` double NOT NULL,
  `photo` varchar(100) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Дамп данных таблицы `locations`
--

INSERT INTO `locations` (`id`, `name`, `latitude_center`, `longitude_center`, `photo`) VALUES
(1, 'Корпуса ИнПИТ имени Гагарина Ю.А.', 23.4, 45.4, 'images/corpuses.png'),
(2, 'dfg', 51.5111, 45.234, 'images/img.png'),
(3, 'Тестовая площадка', 12.123, 12.123, 'images/test.png'),
(4, 'Тестовая площадка', 12.123, 12.123, ''),
(6, 'Тестовая площадка12121212', 12.123, 12.123, ''),
(7, 'Тестовая площадка12121212', 12.123, 12.123, 'uploads/KhyQDT6Rr8ab.png'),
(8, '', 12.123, 12.123, ''),
(9, '', 12.123, 12.123, ''),
(10, '', 12.123, 12.123, ''),
(11, '', 12.123, 12.123, ''),
(12, '', 12.123, 12.123, 'uploads/4DShzTr6RA4r.jpg'),
(13, '', 12.123, 12.123, '');

-- --------------------------------------------------------

--
-- Структура таблицы `species`
--

CREATE TABLE `species` (
  `id` int NOT NULL,
  `name` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Дамп данных таблицы `species`
--

INSERT INTO `species` (`id`, `name`) VALUES
(1, 'Тополь 2'),
(2, 'Клен'),
(3, 'Туя'),
(4, 'Клен');

-- --------------------------------------------------------

--
-- Структура таблицы `statuses`
--

CREATE TABLE `statuses` (
  `id` int NOT NULL,
  `name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Дамп данных таблицы `statuses`
--

INSERT INTO `statuses` (`id`, `name`) VALUES
(1, 'спиленный'),
(2, 'сухой');

-- --------------------------------------------------------

--
-- Структура таблицы `trees`
--

CREATE TABLE `trees` (
  `id` bigint NOT NULL,
  `id_location` int NOT NULL,
  `tree_number` bigint NOT NULL DEFAULT '1' COMMENT 'через триггер менять',
  `id_species` int NOT NULL,
  `state_comment` varchar(100) DEFAULT NULL,
  `latitude` double NOT NULL,
  `longitude` double NOT NULL,
  `height` int NOT NULL COMMENT 'в сантиметрах',
  `tdiameter` int NOT NULL COMMENT 'в сантиметрах',
  `cdiameter` int NOT NULL COMMENT 'в сантиметрах',
  `dry` tinyint(1) NOT NULL DEFAULT '0',
  `detachment` tinyint(1) NOT NULL DEFAULT '0',
  `cracks` tinyint(1) NOT NULL DEFAULT '0',
  `drips` tinyint(1) NOT NULL DEFAULT '0',
  `tilt` tinyint NOT NULL DEFAULT '0' COMMENT 'в градусах',
  `overhanging_t` tinyint(1) NOT NULL DEFAULT '0',
  `overhanging_p` tinyint(1) NOT NULL DEFAULT '0',
  `overhanging_comments` text CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci,
  `overhanging_d` tinyint(1) NOT NULL DEFAULT '0',
  `archive` tinyint(1) NOT NULL DEFAULT '0' COMMENT '1 - дерево заархивировано',
  `photo` varchar(200) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Дамп данных таблицы `trees`
--

INSERT INTO `trees` (`id`, `id_location`, `tree_number`, `id_species`, `state_comment`, `latitude`, `longitude`, `height`, `tdiameter`, `cdiameter`, `dry`, `detachment`, `cracks`, `drips`, `tilt`, `overhanging_t`, `overhanging_p`, `overhanging_comments`, `overhanging_d`, `archive`, `photo`) VALUES
(1, 1, 1, 1, '1', 51.445, 45.345, 123, 45, 123, 0, 0, 0, 0, 45, 0, 0, NULL, 0, 0, ''),
(3, 1, 2, 1, '1', 51.5444, 35.32452, 234, 12, 345, 0, 0, 0, 0, 0, 0, 0, NULL, 0, 0, 'uploads/test.png'),
(4, 1, 3, 1, '1', 51.5444, 35.32452, 234, 12, 345, 0, 0, 0, 0, 0, 0, 0, NULL, 0, 0, 'uploads/test.png'),
(5, 1, 4, 2, '1', 51.445, 45.345, 123, 45, 123, 0, 0, 0, 0, 45, 0, 0, 'Нависает над проводами газопровода', 0, 0, 'uploads/1-1 - a6Adz3i6.png'),
(6, 1, 5, 1, '1', 51.445, 45.345, 123, 45, 123, 0, 0, 0, 0, 45, 0, 0, '', 0, 0, 'uploads/1-1-tsrF6t38.ru'),
(7, 1, 6, 1, '1', 51.445, 45.345, 123, 45, 123, 0, 0, 0, 0, 45, 0, 0, '', 0, 0, ''),
(8, 1, 7, 1, '1', 51.445, 45.345, 123, 45, 123, 0, 0, 0, 0, 45, 0, 0, NULL, 0, 0, 'uploads/1-1-TbeHZa7H.png'),
(9, 1, 8, 1, '1', 51.445, 45.345, 123, 45, 123, 0, 0, 0, 0, 45, 0, 0, NULL, 0, 0, 'uploads/1-1-77GyNyfR.pdf'),
(10, 1, 9, 1, '1', 51.445, 45.345, 123, 45, 123, 0, 0, 0, 0, 45, 0, 0, NULL, 0, 0, ''),
(11, 1, 10, 2, '1', 51.445, 45.345, 123, 45, 123, 0, 0, 0, 0, 45, 0, 0, NULL, 0, 0, 'uploads/1-1-8ZBH8H8F.png'),
(12, 1, 11, 1, '1', 51.445, 45.345, 123, 45, 123, 0, 0, 0, 0, 45, 0, 0, NULL, 0, 0, ''),
(13, 1, 12, 1, '1', 51.445, 45.345, 123, 45, 123, 0, 0, 0, 0, 45, 0, 0, NULL, 0, 0, 'uploads/1-1-SEbhaRKN.ru'),
(14, 1, 13, 1, '1', 51.445, 45.345, 123, 45, 123, 0, 0, 0, 0, 45, 0, 0, NULL, 0, 0, 'uploads/1-1-872KHzFS.png'),
(15, 1, 14, 1, '1', 51.445, 45.345, 123, 45, 123, 0, 0, 0, 0, 45, 0, 0, NULL, 0, 0, 'uploads/1-1-HES2fbiK.pdf'),
(16, 1, 15, 1, '1', 51.445, 45.345, 123, 45, 123, 0, 0, 0, 0, 45, 0, 0, NULL, 0, 0, 'uploads/1-1-4SkbeK8R.ru'),
(17, 1, 16, 1, '1', 51.445, 45.345, 123, 45, 123, 0, 0, 0, 0, 45, 0, 0, NULL, 0, 0, 'uploads/1-1-EyAh6aE3.ru'),
(18, 1, 17, 1, '1', 51.445, 45.345, 123, 45, 123, 0, 0, 0, 0, 45, 0, 0, NULL, 0, 0, 'uploads/1-1-Gkkf8D8N.pdf'),
(19, 1, 18, 2, '1', 51.445, 45.345, 123, 45, 123, 0, 0, 0, 0, 45, 0, 0, NULL, 0, 0, 'uploads/1-1-654EQt3n.ru'),
(20, 1, 19, 2, '1', 51.445, 45.345, 123, 45, 123, 0, 0, 0, 0, 45, 0, 0, 'Тест коммент', 0, 0, 'uploads/1-1-zEeaEYYr.pdf'),
(21, 4, 1, 3, NULL, 51.540273, 46.039105, 2, 0, 1, 0, 0, 0, 0, 0, 0, 0, NULL, 0, 0, '1-6; туя.jpg'),
(22, 4, 2, 3, NULL, 51.540273, 46.039105, 2, 0, 1, 0, 0, 0, 0, 0, 0, 0, NULL, 0, 0, '1-6; туя.jpg'),
(23, 1, 20, 1, NULL, 51.445, 45.345, 123, 45, 123, 0, 0, 0, 0, 45, 0, 0, NULL, 0, 0, ''),
(24, 1, 21, 1, NULL, 51.445, 45.345, 123, 45, 123, 0, 0, 0, 0, 45, 0, 0, 'Тест коммент', 0, 0, ''),
(25, 1, 22, 1, NULL, 51.445, 45.345, 123, 45, 123, 0, 0, 0, 0, 45, 0, 0, 'Тест коммент', 0, 0, 'uploads/-1-N7iSRDhb.jpg'),
(26, 4, 3, 3, NULL, 51.540273, 46.039105, 2, 0, 1, 0, 0, 0, 0, 0, 0, 0, NULL, 0, 0, '1-6; туя.jpg'),
(27, 4, 4, 3, NULL, 51.540273, 46.039105, 2, 0, 1, 0, 0, 0, 0, 0, 0, 0, NULL, 0, 0, '1-6; туя.jpg'),
(28, 4, 5, 3, NULL, 51.540273, 46.039105, 2, 0, 1, 0, 0, 0, 0, 0, 0, 0, NULL, 0, 0, '1-6; туя.jpg'),
(29, 4, 6, 3, NULL, 51.540273, 46.039105, 2, 0, 1, 0, 0, 0, 0, 0, 0, 0, NULL, 0, 0, '1-6; туя.jpg');

--
-- Триггеры `trees`
--
DELIMITER $$
CREATE TRIGGER `Trigger2` BEFORE INSERT ON `trees` FOR EACH ROW BEGIN
SET @last_num = (SELECT MAX(tree_number) from trees where id_location = NEW.id_location);

SET NEW.tree_number = (case when (@last_num IS NULL)
 THEN
      1
 ELSE
      @last_num+1
 END);
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `login` varchar(50) NOT NULL,
  `password` varchar(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `surname` varchar(100) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `patronymic` varchar(100) DEFAULT NULL,
  `role` tinyint NOT NULL COMMENT '0 - админ, 1 - суперадмин'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `login`, `password`, `name`, `surname`, `patronymic`, `role`) VALUES
(1, 'superadmin', '27974dd53473193b1cf4839801d22425', 'Супер', 'Администратор', '', 1),
(3, 'admin', 'd7c6c07a0a04ba4e65921e2f90726384', 'Супер', 'Админ', '', 0);

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `locations`
--
ALTER TABLE `locations`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `species`
--
ALTER TABLE `species`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `statuses`
--
ALTER TABLE `statuses`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `trees`
--
ALTER TABLE `trees`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `login` (`login`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `locations`
--
ALTER TABLE `locations`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT для таблицы `species`
--
ALTER TABLE `species`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT для таблицы `statuses`
--
ALTER TABLE `statuses`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT для таблицы `trees`
--
ALTER TABLE `trees`
  MODIFY `id` bigint NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
