-- --
-- 20111015.sql
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
`email` VARCHAR( 255 ) NOT NULL UNIQUE ,
`password` VARCHAR( 40 ) NOT NULL ,
`name` VARCHAR( 100 ) NULL ,
`admin` TINYINT NOT NULL DEFAULT 0 ,
`active` TINYINT NOT NULL DEFAULT 1 
) ENGINE = InnoDB CHARACTER SET utf8 COLLATE utf8_unicode_ci ;

-- Card table records existing cards. Currently only very basic info is kept but 
-- this table is expected to grow in future releases. 
CREATE TABLE `Card` (
`cardId` INT UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT ,
`name` VARCHAR( 150 ) NOT NULL ,
`rules` TEXT NOT NULL ,
`image` VARCHAR( 36 ) NOT NULL ,
`cardscapeId` INT UNSIGNED NULL ,
`active` TINYINT NOT NULL DEFAULT 1 
) ENGINE = InnoDB CHARACTER SET utf8 COLLATE utf8_unicode_ci ;

-- Decks created by users and used to play games.
-- The deck is identified by a name only to ease its use.
CREATE TABLE `Deck` (
`deckId` INT UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT ,
`name` VARCHAR( 100 ) NULL ,
`userId` INT UNSIGNED NOT NULL ,
`created` DATETIME NOT NULL ,
`active` TINYINT NOT NULL DEFAULT 1 ,
CONSTRAINT `fkDeckUser` FOREIGN KEY (`userId`) REFERENCES `User`(`userId`)
) ENGINE = InnoDB CHARACTER SET utf8 COLLATE utf8_unicode_ci ;

-- Relationship between a card and a deck allowing users to create decks of 
-- cards.
CREATE TABLE `DeckCard` (
`cardId` INT UNSIGNED NOT NULL ,
`deckId` INT UNSIGNED NOT NULL ,
CONSTRAINT `fkDeckCardDeck` FOREIGN KEY (`deckId`) REFERENCES `Deck`(`deckId`) ,
CONSTRAINT `fkDeckCardCard` FOREIGN KEY (`cardId`) REFERENCES `Card`(`CardId`)
) ENGINE = InnoDB CHARACTER SET utf8 COLLATE utf8_unicode_ci ;

-- Games are stored here, even if they have not started or haven't been played.
CREATE TABLE `Game` (
`gameId` INT UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT ,
`player1` INT UNSIGNED NOT NULL ,
`player2` INT UNSIGNED NULL ,
`created` DATETIME NOT NULL ,
`started` DATETIME NULL ,
`ended` DATETIME NULL ,
`running` TINYINT NOT NULL DEFAULT 0 ,
`deck1` INT UNSIGNED NOT NULL ,
`deck2` INT UNSIGNED NULL ,
`private` TINYINT NOT NULL DEFAULT 0,
CONSTRAINT `fkGameUser1` FOREIGN KEY (`player1`) REFERENCES `User`(`userId`) ,
CONSTRAINT `fkGameUser2` FOREIGN KEY (`player2`) REFERENCES `User`(`userId`) ,
CONSTRAINT `fkGameDeck1` FOREIGN KEY (`deck1`) REFERENCES `Deck`(`deckId`) ,
CONSTRAINT `fkGameDeck2` FOREIGN KEY (`deck2`) REFERENCES `Deck`(`deckId`)
) ENGINE = InnoDB CHARACTER SET utf8 COLLATE utf8_unicode_ci ;

-- Stores messages sent in chats.
-- Messages sent ingame have a game ID and messages sent in the lobby don't.
CREATE TABLE `ChatMessage` (
`messageId` INT UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT ,
`message` TEXT NOT NULL ,
`sent` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ,
`userId` INT UNSIGNED NOT NULL ,
`gameId` INT UNSIGNED NULL ,
CONSTRAINT `fkChatMessageUser` FOREIGN KEY (`userId`) REFERENCES `User`(`userId`) ,
CONSTRAINT `fkChatMessageGame` FOREIGN KEY (`gameId`) REFERENCES `Game`(`gameId`)
) ENGINE = InnoDB CHARACTER SET utf8 COLLATE utf8_unicode_ci ;