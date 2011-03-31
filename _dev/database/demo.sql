-- Inser demo users
INSERT INTO `User`(`name`, `password`, `email`) 
VALUES ('admin', SHA1('admin'), 'knitter@wtactics.org') ;