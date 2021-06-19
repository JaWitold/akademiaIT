CREATE OR REPLACE DATABASE akademiait;
use akademiait;

CREATE TABLE `holidays` (
                            `user` text COLLATE utf8_polish_ci NOT NULL,
                            `type` text COLLATE utf8_polish_ci NOT NULL,
                            `dateFrom` date NOT NULL,
                            `dateTo` date NOT NULL,
                            `file` text COLLATE utf8_polish_ci NOT NULL,
                            `comment` text COLLATE utf8_polish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

CREATE TABLE `users` (
                         `login` varchar(50) COLLATE utf8_polish_ci NOT NULL,
                         `password` text COLLATE utf8_polish_ci NOT NULL,
                         `name` varchar(128) COLLATE utf8_polish_ci NOT NULL,
                         `surname` varchar(128) COLLATE utf8_polish_ci NOT NULL,
                         `sex` varchar(64) COLLATE utf8_polish_ci NOT NULL,
                     PRIMARY KEY (`login`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;