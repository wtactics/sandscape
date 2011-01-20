-- Table to store user information. Currently has only the basic attributes
-- general to this kind of system but will be re-evaluated when/if openID is
-- implemented.
CREATE TABLE `User` (
 `userId` INT UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT ,
 `name` VARCHAR( 50 ) NOT NULL ,
 `email` VARCHAR ( 150 ) NOT NULL UNIQUE ,
 `password` VARCHAR ( 40 ) NOT NULL ,
 `active` TINYINT NOT NULL DEFAULT 1
) ENGINE = InnoDB CHARACTER SET utf8 COLLATE utf8_unicode_ci ;

-- Stores card information. A card is na entity with name, description and
-- an associated file that should contain the card's identity
CREATE TABLE `Card` (
 `cardId` INT UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT ,
 `name` VARCHAR( 50 ) NOT NULL UNIQUE ,
 `description` VARCHAR( 255 ) NULL ,
 `file` VARCHAR( 255 ) NOT NULL ,
 `active` TINYINT NOT NULL DEFAULT 1
) ENGINE = InnoDB CHARACTER SET utf8 COLLATE utf8_unicode_ci ;

-- A deck is a collection of cards that the user can create, and is referred to
-- by a name and a creation date
CREATE TABLE `Deck` (
 `deckId` INT UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT ,
 `name` VARCHAR( 50 ) NOT NULL ,
 `creationDate` DATE NOT NULL ,
 `active` TINYINT NOT NULL DEFAULT 1 ,
 `userId` INT UNSIGNED NOT NULL ,
 CONSTRAINT `fkDeckUser` FOREIGN KEY (`userId`) REFERENCES `User`(`userId`)
) ENGINE = InnoDB CHARACTER SET utf8 COLLATE utf8_unicode_ci ;

-- A game instance will allow the record of game information like it's date,
-- start and end time and associated log file with all game actions
CREATE TABLE `Game` (
 `gameId` INT UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT ,
 `runningDate` DATETIME NOT NULL ,
 `start` TIME NOT NULL ,
 `end` TIME NOT NULL ,
 `log` VARCHAR( 255 ) NULL ,
 `active` TINYINT NOT NULL DEFAULT 1 ,
 `deckIdPlayerA` INT UNSIGNED NOT NULL ,
 `deckIdPlayerB` INT UNSIGNED NOT NULL ,
 `userIdPlayerA` INT UNSIGNED NOT NULL ,
 `userIdPlayerB` INT UNSIGNED NOT NULL ,
 CONSTRAINT `fkGameDeckA` FOREIGN KEY (`deckIdPlayerA`) REFERENCES `Deck`(`deckId`) ,
 CONSTRAINT `fkGameDeckB` FOREIGN KEY (`deckIdPlayerB`) REFERENCES `Deck`(`deckId`) ,
 CONSTRAINT `fkGameUserA` FOREIGN KEY (`userIdPlayerA`) REFERENCES `User`(`userId`) ,
 CONSTRAINT `fkGameUserB` FOREIGN KEY (`userIdPlayerB`) REFERENCES `User`(`userId`)
) ENGINE = InnoDB CHARACTER SET utf8 COLLATE utf8_unicode_ci ;

-- This table represents the association between a Deck and a Card, since it is
-- a many-to-many relation
CREATE TABLE `DeckCard` (
 `deckId` INT UNSIGNED NOT NULL ,
 `cardId` INT UNSIGNED NOT NULL ,
 CONSTRAINT `fkDeckCardDeck` FOREIGN KEY (`deckId`) REFERENCES `Deck`(`deckId`) ,
 CONSTRAINT `fkDeckCardCard` FOREIGN KEY (`cardId`) REFERENCES `Card`(`cardId`)
) ENGINE = InnoDB CHARACTER SET utf8 COLLATE utf8_unicode_ci ;

-- Stores messages from chat sessions.
-- Messages should be deleted after the game is over.
CREATE TABLE `Message` (
 `messageId` INT UNSIGNED NOT NULL AUTO_INCREMENT ,
 `message` VARCHAR( 255 ) NOT NULL ,
 `stamp` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ,
 `gameId` INT UNSIGNED NOT NULL ,
 `userId` INT UNSIGNED NOT NULL ,
 CONSTRAINT `fkMessageGame` FOREIGN KEY (`gameId`) REFERENCES `Game`(`gameId`) ,
 CONSTRAINT `fkMessageUser` FOREIGN KEY (`userId`) REFERENCES `User`(`userId`)
) ENGINE = InnoDB CHARACTER SET utf8 COLLATE utf8_unicode_ci ;