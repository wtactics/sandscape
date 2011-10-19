-- Testing users
INSERT INTO `User`(`userId`, `email`, `password`, `name`, `admin`)
VALUES (1, 'knitter@wtactics.org', SHA1('demoDemo, development hash, please change this in a production server'), 'Knitter', 1),
(2, 'afonso@sandscape.moc', SHA1('demoDemo, development hash, please change this in a production server'), 'Afonso Gonçalves Baldaia', 0),
(3, 'alvaro@sandscape.moc', SHA1('demoDemo, development hash, please change this in a production server'), 'Álvaro Martins', 0), 
(4, 'andre@sandscape.moc', SHA1('demoDemo, development hash, please change this in a production server'), 'André Gonçalves ', 0), 
(5, 'antonio@sandscape.moc', SHA1('demoDemo, development hash, please change this in a production server'), 'António Fernandes', 0), 
(6, 'diogo@sandscape.moc', SHA1('demoDemo, development hash, please change this in a production server'), 'Diogo Cão', 0) ;

-- Decks, 4 decks for the first 4 users
INSERT INTO `Deck`(`deckId`, `name`, `userId`, `created`)
VALUES (1, 'Grave Digger', 1, NOW()), (2, 'Pacifier', 2, NOW()), 
(3, 'My Deck', 3, NOW()), (4, 'Gaians', 4, NOW()) ;

-- Existing demo cards
INSERT INTO `Card`(`cardId`, `name`, `image`, `cardscapeId`, `rules`)
VALUES (1, 'Livin Tree', '0faee65bce7f5bbfad77cdb00a8e0414.jpg', 29, 'Every unused resource pile becomes a Tree Creature until end of turn with x/x, where X is the amount of resources in the RP. Discard one resource card from the RP for each 2 damage it receives.'),
(2, 'Dryads Flute', '1b5df7735569475aa8ebd003557c598e.jpg', 27, 'Remove target non-Gaian attacker from combat before it\'s defender is declared. It remains marked'),
(3, 'Longing for Peace', '6aaa6d9ba4e77aced6f6a1243f91d189.jpg', 33, 'Until end of current turn and the next players turn no attackers can be declared in target front.'),
(4, 'Pathfinders Touch', '6f95560ef99099383cc90a7c97d6e7c5.jpg',,),
(5, 'Merman Brawler', '18e9b964776bbe6c9f6842f1feba8b8b.jpg',,),
(6, 'Doubt of Violence', '21deac7ac82cb90751d565167538e7ff.jpg',,),
(7, 'Elvish Archer', '32ffbefc4281baef0b70ae3c376d0774.jpg',,),
(8, 'Seasons Provision', '42afaf9ff8bcf8a59c00a9ad69343a34.jpg',,),
(9, 'Camoflage Coat', '52f8d315707e029ea4f368cffeb03989.jpg',,),
(10, 'Thunder Arkbalist', '66c1847a4c4a33303bbf295af8a821ba.jpg',,),
(11, 'Bound by Love', '78dd96c06603cc16477b913222fc7388.jpg',,),
(12, 'Sharp Shooter', '84bb51addd8e145f3dffa1da7a392c98.jpg',,),
(13, 'Elvish Shaman', '207ba984070bfdedf138d6513b3b9057.jpg',,),
(14, 'Elvish Scout', '271f77b48827ad0dfb0dbd7b5805d8d3.jpg',,),
(15, 'Algea Armor', '787b8e750f4436e8bd4eff8ce9122c5a.jpg',,),
(16, 'Arknym Half-Tree', '52194ccdfc65104b3fdc56d48a07f292.jpg',,),
(17, 'Green Shield', '682740aebbdf8af3df3ff7c3212d52d0.jpg',,),
(18, 'Elvish Marksman', '8459945aaac3e485b963a3a40ff66bd1.jpg',,),
(19, 'Elvish Captain', 'b2df35112667ae2d09fe2995f4d3aa67.jpg',,),
(20, 'Elvish Ranger', 'c13acdf59c0bba52db8b964023deee3c.jpg',,),
(21, 'Merman Hoplite', 'ccdb9cd145e39ee22df8a09c51458645.jpg',,),
(22, 'Serenity', 'dce7e0fb11c3cce0898d9529c9fac76b.jpg',,),
(23, 'Elvish Fighter', 'e9693f365494e18113d6d661a94c4b7a.jpg',,),
(24, 'Elvish Druid', 'f87c27cffe62777a2c0d9d251024d1b2.jpg',,) ;

-- Make cards belong to decks
INSERT INTO `DeckCard`(`cardId`, `deckId`)
VALUES (1, 1), (2, 1), (3, 1), (4, 1), (5, 1), (6, 1), (7, 1), (8, 1), (9, 1), 
(10, 1), (11, 1), (12, 1), (13, 1), (14, 1), (15, 1), (16, 1), (17, 1), (18, 1), 
(19, 1), (20, 1), (21, 1), (22, 1), (23, 1), (24, 1),
--
(1, 2), (2, 2), (3, 2), (4, 2), (5, 2), (6, 2), (7, 2), (8, 2), (9, 2), 
(10, 2), (11, 2), (12, 2), (13, 2), (14, 2), (15, 2), (16, 2), (17, 2), (18, 2), 
(19, 2), (20, 2), (21, 2), (22, 2), (23, 2), (24, 2),
--
(1, 3), (2, 3), (3, 3), (4, 3), (5, 3), (6, 3), (7, 3), (8, 3), (9, 3), 
(10, 3), (11, 3), (12, 3), (13, 3), (14, 3), (15, 3), (16, 3), (17, 3), (18, 3), 
(19, 3), (20, 3), (21, 3), (22, 3), (23, 3), (24, 3),
--
(1, 4), (2, 4), (3, 4), (4, 4), (5, 4), (6, 4), (7, 4), (8, 4), (9, 4), 
(10, 4), (11, 4), (12, 4), (13, 4), (14, 4), (15, 4), (16, 4), (17, 4), (18, 4), 
(19, 4), (20, 4), (21, 4), (22, 4), (23, 4), (24, 4) ;

-- Create some games
INSERT INTO `Game`(`gameId`, `player1`, `player2`, `created`, `started`, `ended`, `running`, `deck1`, `deck2`, `private`)
VALUES (1, 1, NULL, NOW(), NULL, NULL, 0, 1, NULL, 0), 
(2, 2, 3, NOW(), NOW(), NULL, 1, 2, 3, 0),
(3, 4, NULL, NOW(), NULL, NULL, 0, 4, NULL, 0) ;

-- Place some messages in lobby and in game number 2
INSERT INTO `ChatMessage` (`messageId`, `message`, `userId`, `gameId`)
VALUES (1, 'Hey!', 1, NULL), (2, 'Everybody ready for a new game?', 2, NULL), 
(3, 'Here, lets start on', 1, NULL), (4, 'I can\'t, already playing...', 3, NULL), 
(5, 'I\'ve just created a new game, feel free to join', 1, NULL),
-- game messages
(6, 'Ready?', 3, 2),
(7, 'Yes, you can start', 4, 2) ;