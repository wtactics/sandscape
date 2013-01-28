-- -- 
-- 20111028.sql
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

-- Dropping old unused field
ALTER TABLE `User` DROP `seeTopDown`;

-- New settings: dice usage, game spectator chat
INSERT INTO `Setting` 
VALUES ('useanydice', 1, 'If active, users can choose any dice available in the system otherwise, only the dice selected by the admiistratior will be available.') ,
('gamechatspectators', 1, 'Default setting that controls if spectators can speak in the game chat or not. Can be overriden at the game creation dialog.') ;

-- Adding new fields to Game table
ALTER TABLE `Game` ADD `winnerId` INT UNSIGNED NULL, 
ADD `spectatorsSpeak` TINYINT NOT NULL DEFAULT 0 ;

ALTER TABLE `Game` ADD CONSTRAINT `fkGameUserWinner` FOREIGN KEY (`winnerId`) REFERENCES `User`(`userId`) ;