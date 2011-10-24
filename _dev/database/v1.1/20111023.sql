ALTER TABLE `User` CHANGE `name` `name` VARCHAR( 15 ) NOT NULL UNIQUE ;

ALTER TABLE `Card` CHANGE `image` VARCHAR( 36 ) NULL ;

CREATE TABLE `Setting` (
`name` VARCHAR( 255 ) NOT NULL PRIMARY KEY ,
`value` VARCHAR( 255 ) NULL ,
`description` VARCHAR( 255 ) NULL
) ENGINE = InnoDB CHARACTER SET utf8 COLLATE utf8_unicode_ci ;