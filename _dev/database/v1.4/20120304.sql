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