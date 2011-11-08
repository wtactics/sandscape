-- Allow bigger image names to removed the use of MD5 hashing.
ALTER TABLE `Card` CHANGE `image` `image` VARCHAR ( 150 ) NOT NULL ;

-- Add new setting
INSERT INTO `Setting` VALUES ('cardscapeurl', 'http://chaosrealm.net/wtactics/cardscape', 'The URL for the CardScape system used.') ;

/*
-- WIP
-- Add fields and tables for reputation system
ALTER TABLE `User` ADD `reputation` INT NOT NULL DEFAULT 0 ;

-- Tack the reputation points given
CREATE TABLE `ReputationTracker` (
`giverId` INT UNSIGNED NOT NULL ,
`receiverId` INT UNSIGNED NOT NULL ,
`date` DATETIME NOT NULL ,
CONSTRAINT `fkReputationTrackerGiver` FOREIGN KEY (`giverId`) REFERENCES `User`(`userId` ) ,
CONSTRAINT `fkReputationTrackerReceiver` FOREIGN KEY (`receiverId`) REFERENCES `User`(`userId` )
) ENGINE = InnoDB CHARACTER SET utf8 COLLATE utf8_unicode_ci ;

CREATE TABLE `DeckNotes` (
`deckId` INT UNSIGNED NOT NULL ,
`userId` INT UNSIGNED NOT NULL ,
`gameId` INT UNSIGNED NOT NULL ,
`notes` TEXT NULL ,
PRIMARY KEY (`deckId`, `userId`, `gameId`) ,
CONSTRAINT `fkDeckNotesDeck` FOREIGN KEY (`deckId`) REFERENCES `Deck`(`deckId`) ,
CONSTRAINT `fkDeckNotesUser` FOREIGN KEY (`userId`) REFERENCES `User`(`userId`) ,
CONSTRAINT `fkDeckNotesGame` FOREIGN KEY (`gameId`) REFERENCES `Game`(`gameId`)
) ENGINE = InnoDB CHARACTER SET utf8 COLLATE utf8_unicode_ci ;
*/