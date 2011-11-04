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