ALTER TABLE `Setting` ADD `group` VARCHAR( 25 ) NULL ;

UPDATE `Setting` SET `group` = 'game' WHERE `key` IN ('fixdecknr', 'deckspergame', 'useanydice', 'gamechatspectators') ;
UPDATE `Setting` SET `group` = 'general' WHERE `key` IN ('cardscapeurl', 'allowavatar', 'avatarsize') ;

INSERT INTO `Setting` (`key`, `value`, `group`) VALUES ('sysemail', '', 'general') ;

CREATE TABLE `DeckGameStats`(
`gameId` INT UNSIGNED NOT NULL ,
`deckId` INT UNSIGNED NOT NULL ,
`rating` FLOAT NULL ,
`notes` TEXT NULL ,
PRIMARY KEY (`gameId`, `deckId`) ,
CONSTRAINT `fkDGSGame` FOREIGN KEY (`gameId`) REFERENCES `Game`(`gameId` ) ,
CONSTRAINT `fkDGSDeck` FOREIGN KEY (`deckId`) REFERENCES `Deck`(`deckId` )
) ENGINE = InnoDB CHARACTER SET utf8 COLLATE utf8_unicode_ci ;