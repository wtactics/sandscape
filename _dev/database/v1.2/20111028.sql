ALTER TABLE `User` DROP `seeTopDown`;

ALTER TABLE `Dice` ADD `selected` TINYINT NOT NULL DEFAULT 0 ;

INSERT INTO `Setting` VALUES ('useanydice', 1, 'If active, users can choose any dice available in the system otherwise, only the dice selected by the admiistratior will be available.') ;