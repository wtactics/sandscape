
-- Remove old deck references
ALTER TABLE `Game` DROP FOREIGN KEY `fkGameDeck1`;
ALTER TABLE `Game` DROP FOREIGN KEY `fkGameDeck2`;
ALTER TABLE `Game` DROP KEY `fkGameDeck1`;
ALTER TABLE `Game` DROP KEY `fkGameDeck2`;
ALTER TABLE `Game` DROP `deck1`;
ALTER TABLE `Game` DROP `deck2`;

-- add max number of decks per player
ALTER TABLE `Game` ADD `maxDecks` TNINYINT NOT NULL DEFAULT 1;

-- the game has a graveyard?
ALTER TABLE `Game` ADD `graveyard` TNINYINT NOT NULL DEFAULT 1;

-- players are ready
ALTER TABLE `Game` ADD `player1Ready` TNINYINT NOT NULL DEFAULT 0,
ADD `player2Ready` TNINYINT NOT NULL DEFAULT 0;

-- CREATE Game / Deck link
CREATE TABLE GameDeck (
`gameId` INT UNSIGNED NOT NULL,
`deckId` INT UNSIGNED NOT NULL,
PRIMARY KEY (`gameId`, `deckId`),
CONSTRAINT `fkGameDeckGame` FOREIGN KEY (`gameId`) REFERENCES `Game`(`gameId`),
CONSTRAINT `fkGameDeckDeck` FOREIGN KEY (`deckId`) REFERENCES `Deck`(`deckId`)
) ENGINE = InnoDB CHARACTER SET utf8 COLLATE utf8_unicode_ci ;

DROP TABLE `DeckCard`;
CREATE TABLE `DeckCard` (
`dcId` INT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
`deckId` INT UNSIGNED NOT NULL,
`cardId` INT UNSIGNED NOT NULL,
`CONSTRAINT `fkDCDeck` FOREIGN KEY (`deckId`) REFERENCES `Deck`(`deckId`),
`CONSTRAINT `fkDCCard` FOREIGN KEY (`cardId`) REFERENCES `Card`(`cardId`)
) ENGINE=InnoDB character set utf8 collate utf8_unicode_ci;

ALTER TABLE `ChatMessage` ADD `system` TINYINT NOT NULL DEFAULT 0 ;
