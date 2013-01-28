-- -- 
-- 20111020.sql
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

-- Remove old deck references
ALTER TABLE `Game` DROP FOREIGN KEY `fkGameDeck1`;
ALTER TABLE `Game` DROP FOREIGN KEY `fkGameDeck2`;
ALTER TABLE `Game` DROP KEY `fkGameDeck1`;
ALTER TABLE `Game` DROP KEY `fkGameDeck2`;
ALTER TABLE `Game` DROP `deck1`;
ALTER TABLE `Game` DROP `deck2`;

-- add max number of decks per player
ALTER TABLE `Game` ADD `maxDecks` TINYINT NOT NULL DEFAULT 1;

-- the game has a graveyard?
ALTER TABLE `Game` ADD `graveyard` TINYINT NOT NULL DEFAULT 1;

-- players are ready
ALTER TABLE `Game` ADD `player1Ready` TINYINT NOT NULL DEFAULT 0,
ADD `player2Ready` TINYINT NOT NULL DEFAULT 0;

-- CREATE Game / Deck link
CREATE TABLE GameDeck (
`gameId` INT UNSIGNED NOT NULL,
`deckId` INT UNSIGNED NOT NULL,
PRIMARY KEY (`gameId`, `deckId`),
CONSTRAINT `fkGameDeckGame` FOREIGN KEY (`gameId`) REFERENCES `Game`(`gameId`),
CONSTRAINT `fkGameDeckDeck` FOREIGN KEY (`deckId`) REFERENCES `Deck`(`deckId`)
) ENGINE = InnoDB CHARACTER SET utf8 COLLATE utf8_unicode_ci ;

DROP TABLE `DeckCard`;
CREATE TABLE `DeckCard` (
`dcId` INT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
`deckId` INT UNSIGNED NOT NULL,
`cardId` INT UNSIGNED NOT NULL,
CONSTRAINT `fkDCDeck` FOREIGN KEY (`deckId`) REFERENCES `Deck`(`deckId`),
CONSTRAINT `fkDCCard` FOREIGN KEY (`cardId`) REFERENCES `Card`(`cardId`)
) ENGINE=InnoDB character set utf8 collate utf8_unicode_ci;

ALTER TABLE `ChatMessage` ADD `system` TINYINT NOT NULL DEFAULT 0 ;
