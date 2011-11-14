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