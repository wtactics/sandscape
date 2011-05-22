-- --
-- 20110319.sql
-- 
-- This file is part of SandScape.
-- 
-- SandScape is free software: you can redistribute it and/or modify
-- it under the terms of the GNU General Public License as published by
-- the Free Software Foundation, either version 3 of the License, or
-- (at your option) any later version.
-- 
-- SandScape is distributed in the hope that it will be useful,
-- but WITHOUT ANY WARRANTY; without even the implied warranty of
-- MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
-- GNU General Public License for more details.
-- 
-- You should have received a copy of the GNU General Public License
-- along with SandScape.  If not, see <http://www.gnu.org/licenses/>.
-- 
-- Copyright (c) 2011, the SandScape team and WTactics project.
-- --

-- User table, stores basic user info.
CREATE TABLE `User` (
`userId` INT UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT ,
`name` VARCHAR( 20 ) NOT NULL UNIQUE ,
`password` VARCHAR( 40 ) NOT NULL ,
`email` VARCHAR( 200 ) NOT NULL UNIQUE ,
`key` VARCHAR( 40 ) NULL ,
`visited` DATETIME NULL ,
`emailVisibility` TINYINT NOT NULL DEFAULT 0, -- 0 - only admins, 1 - everyone
`acceptMessages` TINYINT NOT NULL DEFAULT 0, -- 0 none, 1 - admins only, 2, everyone 
`admin` TINYINT NOT NULL DEFAULT 0,
`active` TINYINT NOT NULL DEFAULT 1 
) ENGINE = InnoDB CHARACTER SET utf8 COLLATE utf8_unicode_ci ;

-- Decks created by users and used to play games.
-- The deck is identified by a name only to ease it's use.
CREATE TABLE `Deck` (
`deckId` INT UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT ,
`name` VARCHAR( 100 ) NULL ,
`userId` INT UNSIGNED NOT NULL ,
`created` DATETIME NOT NULL ,
`active` TINYINT NOT NULL DEFAULT 1 ,
CONSTRAINT `fkDeckUser` FOREIGN KEY (`userId`) REFERENCES `User`(`userId`)
) ENGINE = InnoDB CHARACTER SET utf8 COLLATE utf8_unicode_ci ;

-- Represents a card, with all the necessary information.
CREATE TABLE `Card` (
`cardId` INT UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT ,
`name` VARCHAR( 150 ) NOT NULL ,
`faction` VARCHAR( 150 ) NULL ,
`type` VARCHAR( 150 ) NULL ,
`subtype` VARCHAR( 150 ) NULL ,
`cost` TINYINT NULL ,
`threshold` VARCHAR( 100 ) NULL ,
`attack` TINYINT NULL ,
`defense` TINYINT NULL ,
`rules` TEXT NOT NULL ,
`author` VARCHAR( 100 ) NOT NULL ,
`revision` DATETIME NULL ,
`cardscapeId` INT NULL ,
`private` TINYINT NOT NULL DEFAULT 1 ,
`active` TINYINT NOT NULL DEFAULT 1 
) ENGINE = InnoDB CHARACTER SET utf8 COLLATE utf8_unicode_ci ;

-- Stores the image data for a card's image.
-- There will be, mainly, 3 records for each card in this table, one for the 
-- normal size image, one for the reduced size and a rotated reduced version.
-- As opposed to other entities, an image is removed from the database if it's 
-- deleted.
CREATE TABLE `CardImage` (
`imageId` INT UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT ,
`filetype` VARCHAR( 200 ) NOT NULL ,
`filename` VARCHAR( 200 ) NOT NULL ,
`filesize` INT UNSIGNED NOT NULL ,
`filedata` MEDIUMBLOB NOT NULL ,
`cardId` INT UNSIGNED NOT NULL ,
`type` TINYINT NOT NULL DEFAULT 1 , -- 1 - normal size, 2 - reduced, 3 - rotated
CONSTRAINT `fkCardImageCard` FOREIGN KEY (`cardId`) REFERENCES `Card`(`cardId`)
) ENGINE = InnoDB CHARACTER SET utf8 COLLATE utf8_unicode_ci ;

-- Relationship between a card and the user that created it.
-- A record will be available if the card was created by a user and didn't 
-- originate in a sync with CardScape. If the card was imported by the admin 
-- then a record is generated as if the card had been created by the admin user.
CREATE TABLE `Create` (
`cardId` INT UNSIGNED NOT NULL PRIMARY KEY,
`userId` INT UNSIGNED NOT NULL ,
CONSTRAINT `fkCreateCard` FOREIGN KEY (`cardId`) REFERENCES `Card`(`cardId`) ,
CONSTRAINT `fkCreateUser` FOREIGN KEY (`userId`) REFERENCES `User`(`userId`)
) ENGINE = InnoDB CHARACTER SET utf8 COLLATE utf8_unicode_ci ;

-- Relationship between a card and a deck allowing users to create decks of 
-- cards.
CREATE TABLE `Have` (
`cardId` INT UNSIGNED NOT NULL ,
`deckId` INT UNSIGNED NOT NULL
) ENGINE = InnoDB CHARACTER SET utf8 COLLATE utf8_unicode_ci ;

-- A chat session, used for both game chats and the lobby.
CREATE TABLE `Chat` (
`chatId` INT UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT ,
`started` DATETIME NOT NULL ,
`lobby` TINYINT NOT NULL DEFAULT 0
) ENGINE = InnoDB CHARACTER SET utf8 COLLATE utf8_unicode_ci ;

-- Represents an existing game, either running, finished or waithing for the 
-- second player. Also stores the last state of the game if it's running.
-- A game's state is a serialized version of the game engine classes when the 
-- game is running.
-- This table as been de-optimized.
CREATE TABLE `Game` (
`gameId` INT UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT ,
`playerA` INT UNSIGNED NOT NULL ,
`playerB` INT UNSIGNED NULL ,
`created` DATETIME NOT NULL ,
`started` DATETIME NULL ,
`ended` DATETIME NULL ,
`running` TINYINT NOT NULL DEFAULT 0 ,
`deckA` INT UNSIGNED NULL ,
`deckB` INT UNSIGNED NULL ,
`hash` VARCHAR( 8 ) NOT NULL ,  
`chatId` INT UNSIGNED NOT NULL ,
`private` TINYINT NOT NULL DEFAULT 0,
`currentState` TEXT NULL ,
CONSTRAINT `fkGameUserA` FOREIGN KEY (`playerA`) REFERENCES `User`(`userId`) ,
CONSTRAINT `fkGameUserB` FOREIGN KEY (`playerB`) REFERENCES `User`(`userId`) ,
CONSTRAINT `fkGameDeckA` FOREIGN KEY (`deckA`) REFERENCES `Deck`(`deckId`) ,
CONSTRAINT `fkGameDeckB` FOREIGN KEY (`deckB`) REFERENCES `Deck`(`deckId`) ,
CONSTRAINT `fkGameChat` FOREIGN KEY (`chatId`) REFERENCES `Chat`(`chatId`)
) ENGINE = InnoDB CHARACTER SET utf8 COLLATE utf8_unicode_ci ;

-- Relationship that identifies the winner of a game.
CREATE TABLE `Win` (
`userId` INT UNSIGNED NOT NULL ,
`gameId` INT UNSIGNED NOT NULL PRIMARY KEY,
CONSTRAINT `fkWinUser` FOREIGN KEY (`userId`) REFERENCES `User`(`userId`) ,
CONSTRAINT `fkWinGame` FOREIGN KEY (`gameId`) REFERENCES `Game`(`gameId`) 
) ENGINE = InnoDB CHARACTER SET utf8 COLLATE utf8_unicode_ci ;

-- A message sent in one of the chats.
CREATE TABLE `ChatMessage` (
`messageId` INT UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT ,
`message` VARCHAR( 255 ) NOT NULL ,
`sent` DATETIME NOT NULL ,
`userId` INT UNSIGNED NOT NULL ,
`chatId` INT UNSIGNED NOT NULL ,
CONSTRAINT `fkChatMessageUser` FOREIGN KEY (`userId`) REFERENCES `User`(`userId`) ,
CONSTRAINT `fkChatMessageChat` FOREIGN KEY (`chatId`) REFERENCES `Chat`(`chatId`)
) ENGINE = InnoDB CHARACTER SET utf8 COLLATE utf8_unicode_ci ;

-- Relationship identifying the users that are active in a chat.
CREATE TABLE `Participate` (
`userId` INT UNSIGNED NOT NULL ,
`chatId` INT UNSIGNED NOT NULL ,
PRIMARY KEY(`userId`, `chatId`) ,
CONSTRAINT `fkParticipateUser` FOREIGN KEY (`userId`) REFERENCES `User`(`userId`) ,
CONSTRAINT `fkParticipateChat` FOREIGN KEY (`chatId`) REFERENCES `Chat`(`chatId`)
) ENGINE = InnoDB CHARACTER SET utf8 COLLATE utf8_unicode_ci ;
