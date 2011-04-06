-- Insert demo information
INSERT INTO `User`(`name`, `password`, `email`, `emailVisibility`, `acceptMessages`, `admin`, `key`) 
VALUES ('Administrator', SHA1('admin'), 'knitter@wtactics.org', 1, 2, 1, NULL) ,
('John', SHA1('john'), 'john@someplace.moc', 0, 1, 0, NULL) ,
('Doe', SHA1('doe'), 'doe@someplace.moc', 0, 1, 0, SHA1('doe,doe@someplace.moc,Doe')) ;

INSERT INTO `Page`(`pageId`, `title`, `body`)
VALUES ('about', 'SandScape', "<p>Barnaby The Bear's my name, never call me Jack or James, I will sing my way to fame, Barnaby the Bear's my name. Birds taught me to sing, when they took me to their king, first I had to fly, in the sky so high so high, so high so high so high, so - if you want to sing this way, think of what you'd like to say, add a tune and you will see, just how easy it can be. Treacle pudding, fish and chips, fizzy drinks and liquorice, flowers, rivers, sand and sea, snowflakes and the stars are free. La la la la la, la la la la la la la, la la la la la la la, la la la la la la la la la la la la la, so - Barnaby The Bear's my name, never call me Jack or James, I will sing my way to fame, Barnaby the Bear's my name.</p>
<p>Children of the sun, see your time has just begun, searching for your ways, through adventures every day. Every day and night, with the condor in flight, with all your friends in tow, you search for the Cities of Gold. Ah-ah-ah-ah-ah... wishing for The Cities of Gold. Ah-ah-ah-ah-ah... some day we will find The Cities of Gold. Do-do-do-do ah-ah-ah, do-do-do-do, Cities of Gold. Do-do-do-do, Cities of Gold. Ah-ah-ah-ah-ah... some day we will find The Cities of Gold.</p>
<p>80 days around the world, we'll find a pot of gold just sitting where the rainbow's ending. Time - we'll fight against the time, and we'll fly on the white wings of the wind. 80 days around the world, no we won't say a word before the ship is really back. Round, round, all around the world. Round, all around the world. Round, all around the world. Round, all around the world.</p>");

INSERT INTO `Message` (`subject`, `body`, `sender`, `receiver`)
VALUES ('Test message', 'Hi, just testing the message system', 1, 2) ,
('Test message 2', 'Hi, just testing the message system, again.', 2, 3) ,
('Test message 3', 'Hi, just testing the message system one more time', 2, 1) ;

INSERT INTO `Chat` (`started`, `lobby`) VALUES (NOW(), 1) ;

INSERT INTO `Participate` (`userId`, `chatId`) VALUES(1, 1), (2, 1), (3, 1) ;

INSERT INTO `Deck` (`name`, `userId`, `created`) VALUES('Demo DK 1', 2, NOW());
