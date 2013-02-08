-- -- 
-- 201203004.sql
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

CREATE TABLE `Title` (
`titleId` INT UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT ,
`description` VARCHAR( 150 ) NOT NULL UNIQUE ,
`active` TINYINT NOT NULL DEFAULT 1
) ENGINE = InnoDB CHARACTER SET utf8 COLLATE utf8_unicode_ci ;

CREATE TABLE `Reward` (
`rewardId` INT UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT ,
`description` VARCHAR( 150 ) NOT NULL ,
`icon` VARCHAR( 255 ) NULL ,
`resusable` TINYINT NOT NULL DEFAULT 0 ,
`active` TINYINT NOT NULL DEFAULT 1
) ENGINE = InnoDB CHARACTER SET utf8 COLLATE utf8_unicode_ci ;

CREATE TABLE `UserTitle` (
`titleId` INT UNSIGNED NOT NULL ,
`userId` INT UNSIGNED NOT NULL ,
PRIMARY KEY (`titleId`, `userId`) ,
CONSTRAINT `fkUserTitleTitle` FOREIGN KEY (`titleId`) REFERENCES `Title`(`titleId`) ,
CONSTRAINT `fkUserTitleUser` FOREIGN KEY (`userId`) REFERENCES `User`(`userId`)
) ENGINE = InnoDB CHARACTER SET utf8 COLLATE utf8_unicode_ci ;

CREATE TABLE `UserReward` (
`rewardId` INT UNSIGNED NOT NULL ,
`userId` INT UNSIGNED NOT NULL ,
PRIMARY KEY (`rewardId`, `userId`),
CONSTRAINT `fkUserRewardReward` FOREIGN KEY (`rewardId`) REFERENCES `Reward`(`rewardId`) ,
CONSTRAINT `fkUserRewardUser` FOREIGN KEY (`userId`) REFERENCES `User`(`userId`)
) ENGINE = InnoDB CHARACTER SET utf8 COLLATE utf8_unicode_ci ;

-- Adding more profile options
ALTER TABLE `User` ADD `reverseCards` TINYINT NOT NULL DEFAULT 1 ;
ALTER TABLE `User` ADD `onHoverDetails` TINYINT NOT NULL DEFAULT 1 ;