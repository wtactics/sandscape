-- Setting table will store configuration options for Sandscape and the games.
CREATE TABLE `Setting` (
`key` VARCHAR( 50 ) NOT NULL PRIMARY KEY ,
`value` TEXT NOT NULL ,
`description` TEXT NULL
) ENGINE=MyISAM CHARACTER SET utf8 COLLATE utf8_unicode_ci ;

-- Some of the current existing settings
INSERT INTO `Setting` 
VALUES ('wordfilter', '', 'Comma separated list of words that will be filtered by the chat system, both in-game and lobby.'),
('fixdecknr', '0', 'Fixes the number of decks used in every game.'),
('deckspergame', '1', 'The number of decks to use in a game, if system allows for variable decks number this setting is ignored.');

-- Deck templates for pre-cons decks.
CREATE TABLE `DeckTemplate` (
`deckTemplateId` INT UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT ,
`name` VARCHAR( 100 ) NOT NULL ,
`created` DATETIME NOT NULL ,
`active` TINYINT NOT NULL DEFAULT 1 
) ENGINE=InnoDB CHARACTER SET utf8 COLLATE utf8_unicode_ci ;

CREATE TABLE `DeckTemplateCard` (
`dtcId` INT UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT ,
`cardId` INT UNSIGNED NOT NULL ,
`deckTemplateId` INT UNSIGNED NOT NULL ,
CONSTRAINT `fkDDeckTemplate` FOREIGN KEY (`deckTemplateId`) REFERENCES `DeckTemplate`(`deckTemplateId`) ,
CONSTRAINT `fkDTemplateCCard` FOREIGN KEY (`cardId`) REFERENCES `Card`(`CardId`)
) ENGINE = InnoDB CHARACTER SET utf8 COLLATE utf8_unicode_ci ;

-- Correct 'name' field on Deck table: should be a required value.
ALTER TABLE `Deck` CHANGE `name` `name` VARCHAR( 100 ) NOT NULL ;