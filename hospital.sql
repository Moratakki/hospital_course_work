-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1
-- Время создания: Июн 15 2025 г., 19:37
-- Версия сервера: 10.4.32-MariaDB
-- Версия PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `hospital`
--

-- --------------------------------------------------------

--
-- Структура таблицы `медкарта`
--

CREATE TABLE `медкарта` (
  `patient_id` int(11) NOT NULL,
  `card_id` int(11) NOT NULL,
  `creation_date` date DEFAULT NULL,
  `employee_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

-- --------------------------------------------------------

--
-- Структура таблицы `диагнозы`
--

CREATE TABLE `диагнозы` (
  `diagnosis_id` int(11) NOT NULL,
  `ICD_10` varchar(10) DEFAULT NULL,
  `diagnosis_name` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

-- --------------------------------------------------------

--
-- Структура таблицы `диагнозы_пациента`
--

CREATE TABLE `диагнозы_пациента` (
  `card_id` int(11) NOT NULL,
  `patient_diagnosis_id` int(11) NOT NULL,
  `diagnosis_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

-- --------------------------------------------------------

--
-- Структура таблицы `пациент`
--

CREATE TABLE `пациент` (
  `patient_id` int(11) NOT NULL,
  `name` varchar(120) DEFAULT NULL,
  `passport_data` varchar(40) DEFAULT NULL,
  `insurance_policy_number` int(11) DEFAULT NULL,
  `admission_time` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

-- --------------------------------------------------------

--
-- Структура таблицы `анализ`
--

CREATE TABLE `анализ` (
  `analysis_id` int(11) NOT NULL,
  `analysis_name` varchar(80) DEFAULT NULL,
  `description` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

-- --------------------------------------------------------

--
-- Структура таблицы `анализы_пациента`
--

CREATE TABLE `анализы_пациента` (
  `card_id` int(11) NOT NULL,
  `appointment_date` date DEFAULT NULL,
  `completion_date` date DEFAULT NULL,
  `results` varchar(100) DEFAULT NULL,
  `patient_analysis_id` int(11) NOT NULL,
  `analysis_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

-- --------------------------------------------------------

--
-- Структура таблицы `выписка`
--

CREATE TABLE `выписка` (
  `card_id` int(11) DEFAULT NULL,
  `discharge_id` int(11) NOT NULL,
  `discharge_date` date DEFAULT NULL,
  `recommendations` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

-- --------------------------------------------------------

--
-- Структура таблицы `назначения`
--

CREATE TABLE `назначения` (
  `card_id` int(11) DEFAULT NULL,
  `appointment_id` int(11) NOT NULL,
  `description` varchar(100) DEFAULT NULL,
  `appointment_date` date DEFAULT NULL,
  `completion_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

-- --------------------------------------------------------

--
-- Структура таблицы `осмотр`
--

CREATE TABLE `осмотр` (
  `card_id` int(11) NOT NULL,
  `inspection_id` int(11) NOT NULL,
  `datetime` date DEFAULT NULL,
  `preliminary_diagnosis` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

-- --------------------------------------------------------

--
-- Структура таблицы `сотрудник`
--

CREATE TABLE `сотрудник` (
  `employee_id` int(11) NOT NULL,
  `name` varchar(120) DEFAULT NULL,
  `post` varchar(40) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `медкарта`
--
ALTER TABLE `медкарта`
  ADD PRIMARY KEY (`card_id`),
  ADD KEY `R_1` (`patient_id`),
  ADD KEY `R_27` (`employee_id`);

--
-- Индексы таблицы `диагнозы`
--
ALTER TABLE `диагнозы`
  ADD PRIMARY KEY (`diagnosis_id`);

--
-- Индексы таблицы `диагнозы_пациента`
--
ALTER TABLE `диагнозы_пациента`
  ADD PRIMARY KEY (`patient_diagnosis_id`),
  ADD KEY `R_28` (`card_id`),
  ADD KEY `R_29` (`diagnosis_id`);

--
-- Индексы таблицы `пациент`
--
ALTER TABLE `пациент`
  ADD PRIMARY KEY (`patient_id`);

--
-- Индексы таблицы `анализ`
--
ALTER TABLE `анализ`
  ADD PRIMARY KEY (`analysis_id`);

--
-- Индексы таблицы `анализы_пациента`
--
ALTER TABLE `анализы_пациента`
  ADD PRIMARY KEY (`patient_analysis_id`),
  ADD KEY `R_20` (`card_id`),
  ADD KEY `R_21` (`analysis_id`);

--
-- Индексы таблицы `выписка`
--
ALTER TABLE `выписка`
  ADD PRIMARY KEY (`discharge_id`),
  ADD KEY `R_22` (`card_id`);

--
-- Индексы таблицы `назначения`
--
ALTER TABLE `назначения`
  ADD PRIMARY KEY (`appointment_id`),
  ADD KEY `R_24` (`card_id`);

--
-- Индексы таблицы `осмотр`
--
ALTER TABLE `осмотр`
  ADD PRIMARY KEY (`inspection_id`),
  ADD KEY `R_2` (`card_id`);

--
-- Индексы таблицы `сотрудник`
--
ALTER TABLE `сотрудник`
  ADD PRIMARY KEY (`employee_id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `пациент`
--
ALTER TABLE `пациент`
  MODIFY `patient_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `медкарта`
--
ALTER TABLE `медкарта`
  ADD CONSTRAINT `R_1` FOREIGN KEY (`patient_id`) REFERENCES `пациент` (`patient_id`),
  ADD CONSTRAINT `R_27` FOREIGN KEY (`employee_id`) REFERENCES `сотрудник` (`employee_id`);

--
-- Ограничения внешнего ключа таблицы `диагнозы_пациента`
--
ALTER TABLE `диагнозы_пациента`
  ADD CONSTRAINT `R_28` FOREIGN KEY (`card_id`) REFERENCES `медкарта` (`card_id`),
  ADD CONSTRAINT `R_29` FOREIGN KEY (`diagnosis_id`) REFERENCES `диагнозы` (`diagnosis_id`);

--
-- Ограничения внешнего ключа таблицы `анализы_пациента`
--
ALTER TABLE `анализы_пациента`
  ADD CONSTRAINT `R_20` FOREIGN KEY (`card_id`) REFERENCES `медкарта` (`card_id`),
  ADD CONSTRAINT `R_21` FOREIGN KEY (`analysis_id`) REFERENCES `анализ` (`analysis_id`);

--
-- Ограничения внешнего ключа таблицы `выписка`
--
ALTER TABLE `выписка`
  ADD CONSTRAINT `R_22` FOREIGN KEY (`card_id`) REFERENCES `медкарта` (`card_id`);

--
-- Ограничения внешнего ключа таблицы `назначения`
--
ALTER TABLE `назначения`
  ADD CONSTRAINT `R_24` FOREIGN KEY (`card_id`) REFERENCES `медкарта` (`card_id`);

--
-- Ограничения внешнего ключа таблицы `осмотр`
--
ALTER TABLE `осмотр`
  ADD CONSTRAINT `R_2` FOREIGN KEY (`card_id`) REFERENCES `медкарта` (`card_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
