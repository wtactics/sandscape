-- -- 
-- 20120228.sql
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

ALTER TABLE `Setting` ADD `group` VARCHAR( 25 ) NULL ;

UPDATE `Setting` SET `group` = 'game' WHERE `key` IN ('fixdecknr', 'deckspergame', 'useanydice', 'gamechatspectators') ;
UPDATE `Setting` SET `group` = 'general' WHERE `key` IN ('cardscapeurl', 'allowavatar', 'avatarsize') ;

INSERT INTO `Setting` (`key`, `value`, `group`) VALUES ('sysemail', '', 'general') ;

CREATE TABLE `DeckGameStats`(
`gameId` INT UNSIGNED NOT NULL ,
`deckId` INT UNSIGNED NOT NULL ,
`rating` FLOAT NULL ,
`notes` TEXT NULL ,
PRIMARY KEY (`gameId`, `deckId`) ,
CONSTRAINT `fkDGSGame` FOREIGN KEY (`gameId`) REFERENCES `Game`(`gameId` ) ,
CONSTRAINT `fkDGSDeck` FOREIGN KEY (`deckId`) REFERENCES `Deck`(`deckId` )
) ENGINE = InnoDB CHARACTER SET utf8 COLLATE utf8_unicode_ci ;