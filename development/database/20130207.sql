-- -- 
-- 20130207.sql
-- 
-- This file is part of Sandscape, a virtual, browser based, table allowing 
-- people to play a customizable card games (CCG) online.
-- Copyright (c) 2011 - 2013, the Sandscape team.
-- 
-- Sandscape uses several third party libraries and resources, a complete list 
-- can be found in the <README> file and in <_dev/thirdparty/about.html>.
-- 
-- Sandscape's team members are listed in the <CONTRIBUTORS> file.
-- 
-- This program is free software: you can redistribute it and/or modify
-- it under the terms of the GNU Affero General Public License as published by
-- the Free Software Foundation, either version 3 of the License, or
-- (at your option) any later version.
-- 
-- This program is distributed in the hope that it will be useful,
-- but WITHOUT ANY WARRANTY; without even the implied warranty of
-- MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
-- GNU Affero General Public License for more details.
-- 
-- You should have received a copy of the GNU Affero General Public License
-- along with this program.  If not, see <http://www.gnu.org/licenses/>.
-- -- 

CREATE TABLE `SessionData` (
`id` INT UNSIGNED NOT NULL PRIMARY KEY ,
`token` VARCHAR( 32 ) NULL, 
`tokenExpires` DATETIME NULL ,
`lastActivity` DATETIME NULL
) ENGINE = MyISAM ;

CREATE TABLE `User` (
`id` INT UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT ,
`email` VARCHAR( 255 ) NOT NULL UNIQUE ,
`password` VARCHAR( 40 ) NOT NULL ,
`name` VARCHAR( 150 ) NULL ,
`seeTopDown` TINYINT NOT NULL DEFAULT 0 ,
`showChatTimes` TINYINT NOT NULL DEFAULT 1 ,
`role` VARCHAR( 15 ) NOT NULL DEFAULT 'player' ,
`avatar` VARCHAR( 255 ) NULL ,
`gender` TINYINT NULL ,
`birthyear` SMALLINT NULL ,
`website` VARCHAR( 255 ) NULL ,
`twitter` VARCHAR( 255 ) NULL ,
`facebook` VARCHAR( 255 ) NULL ,
`googleplus` VARCHAR( 255 ) NULL ,
`skype` VARCHAR( 255 ) NULL ,
`msn` VARCHAR( 255 ) NULL ,
`country` VARCHAR( 2 ) NULL ,
`reverseCards` TINYINT NOT NULL DEFAULT 1 ,
`onHoverDetails` TINYINT NOT NULL DEFAULT 1 ,
`handCorner` TINYINT NOT NULL DEFAULT 1 ,
`active` TINYINT NOT NULL DEFAULT 1
) ENGINE = InnoDB CHARACTER SET utf8 COLLATE utf8_unicode_ci ;

-- Card table records existing cards. Currently only very basic info is kept but 
-- this table is expected to grow in future releases. 
CREATE TABLE `Card` (
`id` INT UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT ,
`name` VARCHAR( 150 ) NOT NULL ,
`rules` TEXT NOT NULL ,
`image` VARCHAR( 255 ) NOT NULL ,
`cardscapeId` INT UNSIGNED NULL ,
`active` TINYINT NOT NULL DEFAULT 1 
) ENGINE = InnoDB CHARACTER SET utf8 COLLATE utf8_unicode_ci ;

-- Decks created by users and used to play games.
-- The deck is identified by a name only to ease its use.
CREATE TABLE `Deck` (
`id` INT UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT ,
`name` VARCHAR( 100 ) NULL ,
`userId` INT UNSIGNED NOT NULL ,
`created` DATETIME NOT NULL ,
`active` TINYINT NOT NULL DEFAULT 1 ,
CONSTRAINT `fkDeckUser` FOREIGN KEY (`userId`) REFERENCES `User`(`id`)
) ENGINE = InnoDB CHARACTER SET utf8 COLLATE utf8_unicode_ci ;

-- Games are stored here, even if they have not started or haven't been played.
CREATE TABLE `Game` (
`id` INT UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT ,
`player1Id` INT UNSIGNED NOT NULL ,
`player2Id` INT UNSIGNED NULL ,
`created` DATETIME NOT NULL ,
`started` DATETIME NULL ,
`ended` DATETIME NULL ,
`state` LONGTEXT NULL
`running` TINYINT NOT NULL DEFAULT 0 ,
`paused` TINYINT NOT NULL DEFAULT 0 ,
`maxDecks` TINYINT NOT NULL DEFAULT 1 ,
`graveyard` TINYINT NOT NULL DEFAULT 1 ,
`player1Ready` TINYINT NOT NULL DEFAULT 0 ,
`player2Ready` TINYINT NOT NULL DEFAULT 0 ,
`spectatorsSpeak` TINYINT NOT NULL DEFAULT 0 ,
`acceptUser` INT UNSIGNED NULL ,
`winnerId` INT UNSIGNED NULL ,
CONSTRAINT `fkGameUserWinner` FOREIGN KEY (`winnerId`) REFERENCES `User`(`id`) ,
CONSTRAINT `fkGameUser1` FOREIGN KEY (`player1Id`) REFERENCES `User`(`id`) ,
CONSTRAINT `fkGameUser2` FOREIGN KEY (`player2Id`) REFERENCES `User`(`id`) ,
CONSTRAINT `fkGameAcceptUser` FOREIGN KEY (`acceptUser`) REFERENCES `User` (`id`)
) ENGINE = InnoDB CHARACTER SET utf8 COLLATE utf8_unicode_ci ;

-- Stores messages sent in chats.
-- Messages sent ingame have a game ID and messages sent in the lobby don't.
CREATE TABLE `ChatMessage` (
`id` INT UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT ,
`message` TEXT NOT NULL ,
`sent` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ,
`userId` INT UNSIGNED NOT NULL ,
`gameId` INT UNSIGNED NULL ,
`system` TINYINT NOT NULL DEFAULT 0 ,
CONSTRAINT `fkChatMessageUser` FOREIGN KEY (`userId`) REFERENCES `User`(`id`) ,
CONSTRAINT `fkChatMessageGame` FOREIGN KEY (`gameId`) REFERENCES `Game`(`id`)
) ENGINE = InnoDB CHARACTER SET utf8 COLLATE utf8_unicode_ci ;

-- CREATE Game / Deck link
CREATE TABLE GameDeck (
`gameId` INT UNSIGNED NOT NULL,
`deckId` INT UNSIGNED NOT NULL,
PRIMARY KEY (`gameId`, `deckId`),
CONSTRAINT `fkGameDeckGame` FOREIGN KEY (`gameId`) REFERENCES `Game`(`id`),
CONSTRAINT `fkGameDeckDeck` FOREIGN KEY (`deckId`) REFERENCES `Deck`(`id`)
) ENGINE = InnoDB CHARACTER SET utf8 COLLATE utf8_unicode_ci ;

CREATE TABLE `DeckCard` (
`deckId` INT UNSIGNED NOT NULL,
`cardId` INT UNSIGNED NOT NULL,
CONSTRAINT `fkDCDeck` FOREIGN KEY (`deckId`) REFERENCES `Deck`(`id`),
CONSTRAINT `fkDCCard` FOREIGN KEY (`cardId`) REFERENCES `Card`(`id`)
) ENGINE=InnoDB character set utf8 collate utf8_unicode_ci;

CREATE TABLE `Token` (
`id` INT UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT ,
`name` VARCHAR( 150 ) NOT NULL ,
`image` VARCHAR( 150 ) NOT NULL ,
`active` TINYINT NOT NULL DEFAULT 1
) ENGINE = InnoDB CHARACTER SET utf8 COLLATE utf8_unicode_ci ;

CREATE TABLE `State` (
`id` INT UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT ,
`name` VARCHAR( 150 ) NOT NULL ,
`image` VARCHAR( 150 ) NOT NULL ,
`active` TINYINT NOT NULL DEFAULT 1
) ENGINE = InnoDB CHARACTER SET utf8 COLLATE utf8_unicode_ci ;

-- Setting table will store configuration options for Sandscape and the games.
CREATE TABLE `Setting` (
`key` VARCHAR( 50 ) NOT NULL PRIMARY KEY ,
`value` TEXT NOT NULL ,
`description` TEXT NULL ,
`group` VARCHAR( 25 )
) ENGINE=MyISAM CHARACTER SET utf8 COLLATE utf8_unicode_ci ;

-- Some of the current existing settings
-- INSERT INTO `Setting` 
-- VALUES ('wordfilter', '', 'Comma separated list of words that will be filtered by the chat system, both in-game and lobby.', 'general') ,
-- ('fixdecknr', '0', 'Fixes the number of decks used in every game.', 'game') ,
-- ('deckspergame', '1', 'The number of decks to use in a game, if system allows for variable decks number this setting is ignored.', 'game') ,
-- ('disabledice', '1', 'All dice will be disabled and users won\'t be able to use dice while playing. If this options is active, any enabled dice will be ignored.') ,
-- ('useanydice', 1, 'If active, users can choose any dice available in the system otherwise, only the dice selected by the admiistratior will be available.', 'game') ,
-- ('gamechatspectators', 1, 'Default setting that controls if spectators can speak in the game chat or not. Can be overriden at the game creation dialog.', 'game') ,
-- ('cardscapeurl', 'http://www.wtactics.org/cardscape', 'The URL for the CardScape.', 'general') ,
-- ('allowavatar', 1, 'Will users be able to upload avatar images.', 'general') ,
-- ('avatarsize', '100x75', 'The size of the avatar image, format is <em>WIDTH</em>x<em>HEIGHT</em>', 'general') ,
-- ('sysemail', '', 'general') ;

CREATE TABLE `Dice` (
`id` INT UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT ,
`face` TINYINT NOT NULL DEFAULT 6 ,
`name` VARCHAR( 150 ) NOT NULL ,
`enabled` TINYINT NOT NULL DEFAULT 1 ,
`active` TINYINT NOT NULL DEFAULT 1 
) ENGINE = InnoDB CHARACTER SET utf8 COLLATE utf8_unicode_ci ;

CREATE TABLE `GameDice` (
`diceId` INT UNSIGNED NOT NULL ,
`gameId` INT UNSIGNED NOT NULL  ,
PRIMARY KEY (`diceId`, `gameId`) ,
CONSTRAINT `fkGameDiceDice` FOREIGN KEY (`diceId`) REFERENCES `Dice`(`id`) ,
CONSTRAINT `fkGameDiceDeck` FOREIGN KEY (`gameId`) REFERENCES `Game`(`id`)
) ENGINE = InnoDB CHARACTER SET utf8 COLLATE utf8_unicode_ci ;

-- Creating tables for player counters, these are created by admins and used in 
-- games
CREATE TABLE `PlayerCounter`(
`id` INT UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT ,
`name` VARCHAR( 255 ) NOT NULL ,
`startValue` INT NOT NULL ,
`step` INT NOT NULL DEFAULT 1 ,
`available` TINYINT NOT NULL DEFAULT 1 ,
`active` TINYINT NOT NULL DEFAULT 1
) ENGINE = InnoDB CHARACTER SET utf8 COLLATE utf8_unicode_ci ;

CREATE TABLE `GamePlayerCounter` (
`gameId`  INT UNSIGNED NOT NULL ,
`playerCounterId` INT UNSIGNED NOT NULL ,
PRIMARY KEY (`gameId`, `playerCounterId`) ,
CONSTRAINT `fkGPCGame` FOREIGN KEY (`gameId`) REFERENCES `Game`(`id`) ,
CONSTRAINT `fkGPCPlayerCounter` FOREIGN KEY (`playerCounterId`) REFERENCES `PlayerCounter`(`id`)
) ENGINE = InnoDB CHARACTER SET utf8 COLLATE utf8_unicode_ci ;

CREATE TABLE `DeckGameStats`(
`gameId` INT UNSIGNED NOT NULL ,
`deckId` INT UNSIGNED NOT NULL ,
`rating` FLOAT NULL ,
`notes` TEXT NULL ,
PRIMARY KEY (`gameId`, `deckId`) ,
CONSTRAINT `fkDGSGame` FOREIGN KEY (`gameId`) REFERENCES `Game`(`id` ) ,
CONSTRAINT `fkDGSDeck` FOREIGN KEY (`deckId`) REFERENCES `Deck`(`id` )
) ENGINE = InnoDB CHARACTER SET utf8 COLLATE utf8_unicode_ci ;
