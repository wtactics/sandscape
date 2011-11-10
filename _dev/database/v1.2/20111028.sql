-- Dropping old unused field
ALTER TABLE `User` DROP `seeTopDown`;

-- New settings: dice usage, game spectator chat
INSERT INTO `Setting` 
VALUES ('useanydice', 1, 'If active, users can choose any dice available in the system otherwise, only the dice selected by the admiistratior will be available.') ,
('gamechatspectators', 1, 'Default setting that controls if spectators can speak in the game chat or not. Can be overriden at the game creation dialog.') ;

-- Adding new fields to Game table
ALTER TABLE `Game` ADD `winnerId` INT UNSIGNED NULL, 
ADD `spectatorsSpeak` TINYINT NOT NULL DEFAULT 0 ;

ALTER TABLE `Game` ADD CONSTRAINT `fkGameUserWinner` FOREIGN KEY (`winnerId`) REFERENCES `User`(`userId`) ;