-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Хост: 10.0.0.57
-- Время создания: Дек 02 2019 г., 17:10
-- Версия сервера: 5.7.26-29
-- Версия PHP: 7.1.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `f0336420_ABC_001`
--

-- --------------------------------------------------------

--
-- Структура таблицы `kategories`
--

CREATE TABLE `kategories` (
  `ID` int(11) NOT NULL,
  `Author` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `Nazvanie` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `Description` text COLLATE utf8_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Дамп данных таблицы `kategories`
--

INSERT INTO `kategories` (`ID`, `Author`, `Nazvanie`, `Description`) VALUES
(2, 'ABC', 'Разное', 'Совсем разное'),
(3, 'SilaTrotila', 'Игровые движки', 'Ldb;rb'),
(4, 'ABC', 'getg', 'ergeg');

-- --------------------------------------------------------

--
-- Структура таблицы `kurs`
--

CREATE TABLE `kurs` (
  `ID` int(11) NOT NULL,
  `Name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `Author` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `ID_kategory` int(11) NOT NULL,
  `Description` text COLLATE utf8_unicode_ci NOT NULL,
  `Ava` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Дамп данных таблицы `kurs`
--

INSERT INTO `kurs` (`ID`, `Name`, `Author`, `ID_kategory`, `Description`, `Ava`) VALUES
(5, 'Как не попасть в спам', 'ABC', 2, 'А вот так', ''),
(6, 'Юнити', 'SilaTrotila', 2, 'ННН', ''),
(7, '2345y4hj', 'ABC', 4, 'hrttyhytt', '');

-- --------------------------------------------------------

--
-- Структура таблицы `news`
--

CREATE TABLE `news` (
  `ID` int(11) NOT NULL,
  `keywords` text COLLATE utf8_unicode_ci,
  `Zagolovok` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `Author` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `Txt` text COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Дамп данных таблицы `news`
--

INSERT INTO `news` (`ID`, `keywords`, `Zagolovok`, `Author`, `Txt`) VALUES
(3, 'ы', 'С чего начать?', 'ABC', 'ы'),
(4, 'в', 'а', 'ABC', 'в');

-- --------------------------------------------------------

--
-- Структура таблицы `oneleson`
--

CREATE TABLE `oneleson` (
  `ID` int(11) NOT NULL,
  `AvaYaUrok` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `Zagolovok` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `keywords` text COLLATE utf8_unicode_ci NOT NULL,
  `TXT` text COLLATE utf8_unicode_ci NOT NULL,
  `Kurs` int(11) NOT NULL,
  `File` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `Video` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `AvaNaVideo` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `Images` text COLLATE utf8_unicode_ci NOT NULL,
  `Cena` int(11) NOT NULL,
  `For_auto_user` tinyint(4) NOT NULL,
  `Author` varchar(30) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Дамп данных таблицы `oneleson`
--

INSERT INTO `oneleson` (`ID`, `AvaYaUrok`, `Zagolovok`, `keywords`, `TXT`, `Kurs`, `File`, `Video`, `AvaNaVideo`, `Images`, `Cena`, `For_auto_user`, `Author`) VALUES
(7, '', 'С чего начать?', '', 'pRESS F', 5, '', '', '', '', 0, 0, 'ABC'),
(8, '', 'УУУУУУУУ', '', 'ЫЫЫЫЫЫ', 6, '', '', '', '', 5, 0, 'SilaTrotila'),
(9, 'resource/Avatars/Kurses/20191126090608Ava_ABC_hashCode.png', 'Игровая индустрия... В ней ли наше будущее', '', 'фыкрвеааншдбьавекиуцй%Ц63ы47вб58ш6ншльб ', 5, '', '', '', '', 0, 0, 'Login'),
(10, '', 'stddhyjuhkvijdlo;hlnh', '', '56j6kij', 7, '', '', '', '', 0, 0, 'ABC');

-- --------------------------------------------------------

--
-- Структура таблицы `polzovatel`
--

CREATE TABLE `polzovatel` (
  `Login` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `Password` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `Podskazka` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `Ava` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `Podtverjden` tinyint(4) NOT NULL,
  `Family` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `Name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `Ottestvo` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `Email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `Doljnost` varchar(25) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Дамп данных таблицы `polzovatel`
--

INSERT INTO `polzovatel` (`Login`, `Password`, `Podskazka`, `Ava`, `Podtverjden`, `Family`, `Name`, `Ottestvo`, `Email`, `Doljnost`) VALUES
('ABC', '01051995', 'Дата рождения', 'resource/Avatars/Profiles/20191124123626Ava_ABC_hashCode.png', 1, 'AHTOHOB', 'BЛАДИMИP', 'CТАHИСЛАBОBИЧ', 'silatrotila0atom@gmail.com', 'владелец'),
('Daria666', 'dasha777', '', '', 1, 'Юдина', 'Дарья', 'Александровна', 'dashaudina06@gmail.com', 'ученик'),
('e', 'e', '', '', 0, 'fff', 'ППП', 'ВВЦВ', '@@@', 'ученик'),
('lkushnikova', '123456', '', '', 0, 'ропсроспро', 'ап', 'чвав', 'sd@gfd.tu', 'ученик'),
('Login', 'Password', '', '', 1, 'Cfif', 'Cthuttd', 'Dsss', 'silatrotila0atom@gmail.com', 'управляющий'),
('SilaTrotila', '01051995', '', '', 1, 'Фамлия', 'Имя', 'Отчество', 'silatrotila0atom@gmail.com', 'директор');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `kategories`
--
ALTER TABLE `kategories`
  ADD PRIMARY KEY (`ID`) USING BTREE,
  ADD KEY `Author` (`Author`);

--
-- Индексы таблицы `kurs`
--
ALTER TABLE `kurs`
  ADD PRIMARY KEY (`ID`) USING BTREE,
  ADD KEY `ID_kategory` (`ID_kategory`),
  ADD KEY `Author` (`Author`);

--
-- Индексы таблицы `news`
--
ALTER TABLE `news`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `Author` (`Author`);

--
-- Индексы таблицы `oneleson`
--
ALTER TABLE `oneleson`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `Kurs` (`Kurs`),
  ADD KEY `Author` (`Author`);

--
-- Индексы таблицы `polzovatel`
--
ALTER TABLE `polzovatel`
  ADD PRIMARY KEY (`Login`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `kategories`
--
ALTER TABLE `kategories`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT для таблицы `kurs`
--
ALTER TABLE `kurs`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT для таблицы `news`
--
ALTER TABLE `news`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT для таблицы `oneleson`
--
ALTER TABLE `oneleson`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `kategories`
--
ALTER TABLE `kategories`
  ADD CONSTRAINT `kategories_ibfk_1` FOREIGN KEY (`Author`) REFERENCES `polzovatel` (`Login`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Ограничения внешнего ключа таблицы `kurs`
--
ALTER TABLE `kurs`
  ADD CONSTRAINT `kurs_ibfk_1` FOREIGN KEY (`ID_kategory`) REFERENCES `kategories` (`ID`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `kurs_ibfk_3` FOREIGN KEY (`Author`) REFERENCES `polzovatel` (`Login`);

--
-- Ограничения внешнего ключа таблицы `news`
--
ALTER TABLE `news`
  ADD CONSTRAINT `news_ibfk_1` FOREIGN KEY (`Author`) REFERENCES `polzovatel` (`Login`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Ограничения внешнего ключа таблицы `oneleson`
--
ALTER TABLE `oneleson`
  ADD CONSTRAINT `oneleson_ibfk_1` FOREIGN KEY (`Author`) REFERENCES `polzovatel` (`Login`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `oneleson_ibfk_2` FOREIGN KEY (`Kurs`) REFERENCES `kurs` (`ID`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
