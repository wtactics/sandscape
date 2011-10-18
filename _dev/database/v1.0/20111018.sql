ALTER TABLE `User` DROP `authenticated` ;

CREATE TABLE `SessionData` (
`userId` INT UNSIGNED NOT NULL PRIMARY KEY ,
`token` VARCHAR( 32 ) NULL, 
`tokenExpires` DATETIME NULL ,
`lastActivity` DATETIME NULL
) ENGINE=MyISAM ;