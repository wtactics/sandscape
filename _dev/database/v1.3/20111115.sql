-- Adding extra profile information, mostly social networks links
ALTER TABLE `User` ADD `avatar` VARCHAR( 255 ) NULL ,
ADD `gender` TINYINT NULL ,
ADD `birthdate` DATE NULL ,
ADD `website` VARCHAR( 255 ) NULL ,
ADD `twitter` VARCHAR( 255 ) NULL ,
ADD `facebook` VARCHAR( 255 ) NULL ,
ADD `googleplus` VARCHAR( 255 ) NULL ,
ADD `skype` VARCHAR( 255 ) NULL ,
ADD `msn` VARCHAR( 255 ) NULL ;

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