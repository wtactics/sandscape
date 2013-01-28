-- -- 
-- 20111115.sql
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

-- Adding extra profile information, mostly social networks links
ALTER TABLE `User` ADD `avatar` VARCHAR( 255 ) NULL ,
ADD `gender` TINYINT NULL ,
ADD `birthyear` SMALLINT NULL ,
ADD `website` VARCHAR( 255 ) NULL ,
ADD `twitter` VARCHAR( 255 ) NULL ,
ADD `facebook` VARCHAR( 255 ) NULL ,
ADD `googleplus` VARCHAR( 255 ) NULL ,
ADD `skype` VARCHAR( 255 ) NULL ,
ADD `msn` VARCHAR( 255 ) NULL ,
ADD `country` VARCHAR( 2 ) NULL ;

-- Add new settings
INSERT INTO `Setting` VALUES ('allowavatar', 1, 'Will users be able to upload avatar images.'), 
('avatarsize', '100x75', 'The size of the avatar image, format is <em>WIDTH</em>x<em>HEIGHT</em>') ;

-- Creating tables for player counters, these are created by admins and used in 
-- games
CREATE TABLE `PlayerCounter`(
`playerCounterId` INT UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT ,
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
CONSTRAINT `fkGPCGame` FOREIGN KEY (`gameId`) REFERENCES `Game`(`gameId`) ,
CONSTRAINT `fkGPCPlayerCounter` FOREIGN KEY (`playerCounterId`) REFERENCES `PlayerCounter`(`playerCounterId`)
) ENGINE = InnoDB CHARACTER SET utf8 COLLATE utf8_unicode_ci ;