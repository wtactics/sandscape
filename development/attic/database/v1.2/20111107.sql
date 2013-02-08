-- -- 
-- 20111107.sql
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

ALTER TABLE `ChatMessage` CHANGE `userId` `userId` INT UNSIGNED NULL ;

-- Allow bigger image names to removed the use of MD5 hashing.
ALTER TABLE `Card` CHANGE `image` `image` VARCHAR ( 150 ) NOT NULL ;

-- Add new setting
INSERT INTO `Setting` VALUES ('cardscapeurl', 'http://www.wtactics.org/cardscape', 'The URL for the CardScape.') ;

CREATE TABLE `Token` (
`tokenId` INT UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT ,
`name` VARCHAR( 150 ) NOT NULL ,
`image` VARCHAR( 150 ) NOT NULL ,
`active` TINYINT NOT NULL DEFAULT 1
) ENGINE = InnoDB CHARACTER SET utf8 COLLATE utf8_unicode_ci ;

CREATE TABLE `State` (
`stateId` INT UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT ,
`name` VARCHAR( 150 ) NOT NULL ,
`image` VARCHAR( 150 ) NOT NULL ,
`active` TINYINT NOT NULL DEFAULT 1
) ENGINE = InnoDB CHARACTER SET utf8 COLLATE utf8_unicode_ci ;