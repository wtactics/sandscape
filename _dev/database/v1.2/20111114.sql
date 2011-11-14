ALTER TABLE `DeckTemplate` ADD `deckId` INT UNSIGNED NOT NULL ;
ALTER TABLE `DeckTemplate` ADD CONSTRAINT `fkDeckTemplateDeck` FOREIGN KEY (`deckId`) REFERENCES `Deck`(`deckId`) ;