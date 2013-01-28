-- -- 
-- 20111025.sql
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

-- Updating Game table
ALTER TABLE `Game` CHANGE `private` `paused` TINYINT NOT NULL DEFAULT 0, 
ADD `acceptUser` INT UNSIGNED NULL ;

ALTER TABLE `Game` ADD CONSTRAINT `fkGameAcceptUser` FOREIGN KEY (`acceptUser`) REFERENCES `User` (`userId`) ;

-- Create Dice table to manage available dice
-- Yes, I know Dice is plural and Die is the correct word, but it's also a reserved 
-- word for PHP!
CREATE TABLE `Dice` (
`diceId` INT UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT ,
`face` TINYINT NOT NULL DEFAULT 6 ,
`name` VARCHAR( 150 ) NOT NULL ,
`enabled` TINYINT NOT NULL DEFAULT 1,
`active` TINYINT NOT NULL DEFAULT 1 
) ENGINE = InnoDB CHARACTER SET utf8 COLLATE utf8_unicode_ci ;

CREATE TABLE `GameDice` (
`diceId` INT UNSIGNED NOT NULL ,
`gameId` INT UNSIGNED NOT NULL  ,
PRIMARY KEY (`diceId`, `gameId`) ,
CONSTRAINT `fkGameDiceDice` FOREIGN KEY (`diceId`) REFERENCES `Dice`(`diceId`) ,
CONSTRAINT `fkGameDiceDeck` FOREIGN KEY (`gameId`) REFERENCES `Game`(`gameId`)
) ENGINE = InnoDB CHARACTER SET utf8 COLLATE utf8_unicode_ci ;

-- Some of the current existing settings
INSERT INTO `Setting` 
VALUES ('disabledice', '1', 'All dice will be disabled and users won\'t be able to use dice while playing. If this options is active, any enabled dice will be ignored.') ;