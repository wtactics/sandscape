ALTER TABLE `User`
    CHANGE `name` `name` VARCHAR( 150 ) NOT NULL ,
    ADD `role` VARCHAR( 15 ) NOT NULL DEFAULT 'player' ,
    DROP `msn` ,
    DROP `class` ;