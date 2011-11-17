-- Adding extra profile information, mostly social networks links
ALTER TABLE `User` ADD `avatar` VARCHAR( 255 ) NULL ,
ADD `gender` TINYINT NULL ,
ADD `birthdate` DATE NULL ,
ADD `website` VARCHAR( 255 ) NULL ,
ADD `twitter` VARCHAR( 255 ) NULL ,
ADD `facebook` VARCHAR( 255 ) NULL ,
ADD `googleplus` VARCHAR( 255 ) NULL ,
ADD `skype` VARCHAR( 255 ) NULL ,
ADD `msn` VARCHAR( 255 ) NULL ;

-- Add new settings
INSERT INTO `Setting` VALUES ('allowavatar', 1, 'Will users be able to upload avatar images.'), 
('avatarsize', '100x75', 'The size of the avatar image, format is <em>WIDTH</em>x<em>HEIGHT</em>') ;