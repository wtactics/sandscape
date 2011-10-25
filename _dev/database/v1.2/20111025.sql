-- Updating Game table
ALTER TABLE `Game` CHANGE `private` `paused` TINYINT NOT NULL DEFAULT 0, 
ADD `acceptUser` INT UNSIGNED NULL ;

ALTER TABLE `Game` ADD CONSTRAINT `fkGameAccpUser` FOREIGN KEY (`acceptUser`) REFERENCES `User` (`userId`) ;

-- Create Dice table to manage available dice
-- Yes, I know Dice is plural and Die is the correct word, but it's also a reserved 
-- word for PHP!
CREATE TABLE `Dice` (
`diceId` INT UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT ,
`face` TINYINT NOT NULL DEFAULT 6 ,
`name` VARCHAR( 150 ) NOT NULL ,
`active` TINYINT NOT NULL DEFAULT 1 
) ENGINE = InnoDB CHARACTER SET utf8 COLLATE utf8_unicode_ci ;

CREATE TABLE `GameDice` (
`diceId` INT UNSIGNED NOT NULL ,
`gameId` INT UNSIGNED NOT NULL  ,
PRIMARY KEY (`diceId`, `gameId`) ,
CONSTRAINT `fkGameDiceDice` FOREIGN KEY (`diceId`) REFERENCES `Dice`(`diceId`) ,
CONSTRAINT `fkGameDiceDeck` FOREIGN KEY (`gameId`) REFERENCES `Game`(`gameId`)
) ENGINE = InnoDB CHARACTER SET utf8 COLLATE utf8_unicode_ci ;