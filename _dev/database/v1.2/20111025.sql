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