-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1
-- Время создания: Июн 07 2023 г., 18:28
-- Версия сервера: 10.4.24-MariaDB
-- Версия PHP: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `kursov`
--

-- --------------------------------------------------------

--
-- Структура таблицы `katalog`
--

CREATE TABLE `katalog` (
  `UDK` varchar(255) NOT NULL,
  `Name` varchar(255) NOT NULL,
  `Title` varchar(255) NOT NULL,
  `DatePub` varchar(255) NOT NULL,
  `Num` varchar(255) NOT NULL,
  `debt` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Дамп данных таблицы `katalog`
--

INSERT INTO `katalog` (`UDK`, `Name`, `Title`, `DatePub`, `Num`, `debt`) VALUES
('004', 'Кузнецова Наталья Владимировна', 'Компьютерные технологии в профессиональной деятельности', '2023', '160', '22'),
('004', 'Федотова Алена Валериевна', 'Построение модели изделия в PDM-системе', '2017', '187', '4'),
('15', 'Быстров Александр Николаевич', 'Искусство быть свободным', '2023', '192', '31'),
('15', 'Меренкова Вера Сергеевна', 'Краткий курс лекций по юридической психологии', '2023', '134', '0');

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `login` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`login`, `password`, `role`) VALUES
('123', '123', 'user'),
('1234', '1234', 'user'),
('12345', '12345', 'user'),
('2314234', '345', 'user'),
('4325435', '45435', 'user'),
('4365645', '456', 'user'),
('876r', '654', 'user'),
('23534563546', '657', 'user'),
('admin', 'admin', 'admin');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD UNIQUE KEY `passwd` (`password`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
