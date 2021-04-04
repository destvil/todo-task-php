-- phpMyAdmin SQL Dump
-- version 4.6.6deb5ubuntu0.5
-- https://www.phpmyadmin.net/
--
-- Хост: localhost:3306
-- Время создания: Апр 04 2021 г., 14:57
-- Версия сервера: 5.7.33-0ubuntu0.18.04.1
-- Версия PHP: 7.4.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

-- --------------------------------------------------------

--
-- Структура таблицы `d_task`
--

CREATE TABLE `d_task` (
  `id` int(11) NOT NULL,
  `userName` varchar(25) NOT NULL,
  `email` varchar(255) NOT NULL,
  `description` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `d_task_status`
--

CREATE TABLE `d_task_status` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `value` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `d_task_status`
--

INSERT INTO `d_task_status` (`id`, `name`, `value`) VALUES
(1, 'success', 'выполнено'),
(2, 'admin_edit', 'отредактировано администратором');

-- --------------------------------------------------------

--
-- Структура таблицы `d_task_task_status`
--

CREATE TABLE `d_task_task_status` (
  `taskId` int(11) NOT NULL,
  `taskStatusId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `d_user`
--

CREATE TABLE `d_user` (
  `id` int(11) NOT NULL,
  `login` varchar(18) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `d_user`
--

INSERT INTO `d_user` (`id`, `login`, `password`) VALUES
(1, 'admin', '$2y$10$VEBrkhOiGMNdFvpnwIcwQOWzxivbABvvalsHRfniFrEbKE4A8TUAe');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `d_task`
--
ALTER TABLE `d_task`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `d_task_status`
--
ALTER TABLE `d_task_status`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `d_task_task_status`
--
ALTER TABLE `d_task_task_status`
  ADD UNIQUE KEY `task_id_task_status_id` (`taskId`,`taskStatusId`) USING BTREE,
  ADD KEY `task_status_id` (`taskStatusId`);

--
-- Индексы таблицы `d_user`
--
ALTER TABLE `d_user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `d_task`
--
ALTER TABLE `d_task`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT для таблицы `d_task_status`
--
ALTER TABLE `d_task_status`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT для таблицы `d_user`
--
ALTER TABLE `d_user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `d_task_task_status`
--
ALTER TABLE `d_task_task_status`
  ADD CONSTRAINT `d_task_task_status_ibfk_1` FOREIGN KEY (`taskId`) REFERENCES `d_task` (`id`),
  ADD CONSTRAINT `d_task_task_status_ibfk_2` FOREIGN KEY (`taskStatusId`) REFERENCES `d_task_status` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
