-- //TODO//NOTE: Work in progress

-- User table, stores basic user info
CREATE TABLE `User` (
`userId` INT UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT ,
`name` VARCHAR( 20 ) NOT NULL UNIQUE ,
`password` VARCHAR( 40 ) NOT NULL ,
`email` VARCHAR( 200 ) NOT NULL UNIQUE ,
`key` VARCHAR( 40 ) NULL ,
`visited` DATETIME NULL ,
`emailVisibility` TINYINT NOT NULL DEFAULT 0, -- 0 - only admins, 1 - everyone
`acceptMessages` TINYINT NOT NULL DEFAULT 0, -- 0 none, 1 - admins only, 2, everyone 
`admin` TINYINT NOT NULL DEFAULT 0,
`active` TINYINT NOT NULL DEFAULT 1 
) ENGINE = InnoDB CHARACTER SET utf8 COLLATE utf8_unicode_ci ;

-- Messages used in the PM system
CREATE TABLE `Message` (
`messageId` INT UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT ,
`subject` VARCHAR( 150 ) NOT NULL ,
`body` TEXT NOT NULL ,
`sender` INT UNSIGNED NOT NULL ,
`receiver` INT UNSIGNED NOT NULL ,
CONSTRAINT `fkMessageUserSender` FOREIGN KEY (`sender`) REFERENCES `User`(`userId`) ,
CONSTRAINT `fkMessageUserReceiver` FOREIGN KEY (`receiver`) REFERENCES `User`(`userId`)
) ENGINE = InnoDB CHARACTER SET utf8 COLLATE utf8_unicode_ci ;

CREATE TABLE `Deck` (
`deckId` INT UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT ,
`userId` INT UNSIGNED NOT NULL ,
`created` DATETIME NOT NULL ,
`active` TINYINT NOT NULL DEFAULT 1 ,
CONSTRAINT `fkDeckUser` FOREIGN KEY (`userId`) REFERENCES `User`(`userId`)
) ENGINE = InnoDB CHARACTER SET utf8 COLLATE utf8_unicode_ci ;

CREATE TABLE `CardImage` (
`imageId` INT UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT ,
`filetype` VARCHAR( 200 ) NOT NULL ,
`filename` VARCHAR( 200 ) NOT NULL ,
`filesize` INT UNSIGNED NOT NULL ,
`filedata` MEDIUMBLOB NOT NULL 
) ENGINE = InnoDB CHARACTER SET utf8 COLLATE utf8_unicode_ci ;

CREATE TABLE `Card` (
`cardId` INT UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT ,
`faction` VARCHAR( 150 ) NULL ,
`type` VARCHAR( 150 ) NULL ,
`subtype` VARCHAR( 150 ) NULL ,
`cost` TINYINT NULL ,
`threshold` VARCHAR( 100 ) NULL ,
`attack` TINYINT NULL ,
`defense` TINYINT NULL ,
`rules` VARCHAR( 255 ) NOT NULL ,
`author` VARCHAR( 100 ) NOT NULL ,
`revision` DATETIME NULL ,
`cardscapeId` INT NULL ,
`imageId` INT UNSIGNED NOT NULL ,
`private` TINYINT NOT NULL DEFAULT 1 ,
`active` TINYINT NOT NULL DEFAULT 1 ,
CONSTRAINT `fkCardCardImage` FOREIGN KEY (`imageId`) REFERENCES `CardImage`(`imageId`) 
) ENGINE = InnoDB CHARACTER SET utf8 COLLATE utf8_unicode_ci ;

CREATE TABLE `Create` (
`cardId` INT UNSIGNED NOT NULL ,
`userId` INT UNSIGNED NOT NULL ,
PRIMARY KEY(`userId`, `cardId`) ,
CONSTRAINT `fkCreateCard` FOREIGN KEY (`cardId`) REFERENCES `Card`(`cardId`) ,
CONSTRAINT `fkCreateUser` FOREIGN KEY (`userId`) REFERENCES `User`(`userId`)
) ENGINE = InnoDB CHARACTER SET utf8 COLLATE utf8_unicode_ci ;

CREATE TABLE `Have` (
`cardId` INT UNSIGNED NOT NULL ,
`deckId` INT UNSIGNED NOT NULL
) ENGINE = InnoDB CHARACTER SET utf8 COLLATE utf8_unicode_ci ;

CREATE TABLE `Chat` (
`chatId` INT UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT ,
`started` DATETIME NOT NULL
) ENGINE = InnoDB CHARACTER SET utf8 COLLATE utf8_unicode_ci ;

CREATE TABLE `Game` (
`gameId` INT UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT ,
`playerA` INT UNSIGNED NOT NULL ,
`playerB` INT UNSIGNED NULL ,
`created` DATETIME NOT NULL ,
`started` DATETIME NULL ,
`ended` DATETIME NULL ,
`running` TINYINT NOT NULL DEFAULT 0 ,
`deckA` INT UNSIGNED NULL ,
`deckB` INT UNSIGNED NULL ,
`hash` VARCHAR( 8 ) NOT NULL ,  
`chatId` INT UNSIGNED NOT NULL ,
`private` TINYINT NOT NULL DEFAULT 0,
CONSTRAINT `fkGameUserA` FOREIGN KEY (`playerA`) REFERENCES `User`(`userId`) ,
CONSTRAINT `fkGameUserB` FOREIGN KEY (`playerB`) REFERENCES `User`(`userId`) ,
CONSTRAINT `fkGameDeckA` FOREIGN KEY (`deckA`) REFERENCES `Deck`(`deckId`) ,
CONSTRAINT `fkGameDeckB` FOREIGN KEY (`deckB`) REFERENCES `Deck`(`deckId`) ,
CONSTRAINT `fkGameChat` FOREIGN KEY (`chatId`) REFERENCES `Chat`(`chatId`)
) ENGINE = InnoDB CHARACTER SET utf8 COLLATE utf8_unicode_ci ;

CREATE TABLE `Win` (
`userId` INT UNSIGNED NOT NULL PRIMARY KEY,
`gameId` INT UNSIGNED NOT NULL ,
CONSTRAINT `fkWinUser` FOREIGN KEY (`userId`) REFERENCES `User`(`userId`) ,
CONSTRAINT `fkWinGame` FOREIGN KEY (`gameId`) REFERENCES `Game`(`gameId`) 
) ENGINE = InnoDB CHARACTER SET utf8 COLLATE utf8_unicode_ci ;

CREATE TABLE `ChatMessage` (
`messageId` INT UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT ,
`message` VARCHAR( 255 ) NOT NULL ,
`sent` DATETIME NOT NULL ,
`userId` INT UNSIGNED NOT NULL ,
`chatId` INT UNSIGNED NOT NULL ,
CONSTRAINT `fkChatMessageUser` FOREIGN KEY (`userId`) REFERENCES `User`(`userId`) ,
CONSTRAINT `fkChatMessageChat` FOREIGN KEY (`chatId`) REFERENCES `Chat`(`chatId`)
) ENGINE = InnoDB CHARACTER SET utf8 COLLATE utf8_unicode_ci ;

CREATE TABLE `Participate` (
`userId` INT UNSIGNED NOT NULL ,
`chatId` INT UNSIGNED NOT NULL ,
PRIMARY KEY(`userId`, `chatId`) ,
CONSTRAINT `fkParticipateUser` FOREIGN KEY (`userId`) REFERENCES `User`(`userId`) ,
CONSTRAINT `fkParticipateChat` FOREIGN KEY (`chatId`) REFERENCES `Chat`(`chatId`)
) ENGINE = InnoDB CHARACTER SET utf8 COLLATE utf8_unicode_ci ;

