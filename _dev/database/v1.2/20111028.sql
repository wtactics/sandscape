-- Dropping old unused field
ALTER TABLE `User` DROP `seeTopDown`;

-- Adding flag to mark a dice as available for play
ALTER TABLE `Dice` ADD `selected` TINYINT NOT NULL DEFAULT 0 ;

-- New settings: dice usage, game spectator chat
INSERT INTO `Setting` 
VALUES ('useanydice', 1, 'If active, users can choose any dice available in the system otherwise, only the dice selected by the admiistratior will be available.') ,
('gamechatspectators', 1, 'Default setting that controls if spectators can speak in the game chat or not. Can be overriden at the game creation dialog.') ;

-- Adding new fields to Game table
ALTER TABLE `Game` ADD `winnerId` INT UNSIGNED NULL, 
`spectatorsSpeak` TINYINT NOT NULL DEFAULT 0 ;

ALTER TABLE `Game` ADD CONSTRAINT `fkGameUserWinner` FOREIGN KEY (`winnerId`) REFERENCES `User`(`userId`) ;

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