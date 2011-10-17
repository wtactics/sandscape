INSERT INTO `User`(`userId`, `email`, `password`, `name`, `admin`)
VALUES (1, 'knitter@wtactics.org', SHA1('demo'), 'Knitter', 1) ;

INSERT INTO `Deck`(`deckId`, `name`, `userId`, `created`)
VALUES (1, 'Grave Digger', 1, NOW()) ;

INSERT INTO `Card`(`cardId`, `name`, `rules`, `image`)
VALUES (1, 'Livin Tree', '', '0faee65bce7f5bbfad77cdb00a8e0414.jpg') ,
(2, 'Dryads Flute', '', '1b5df7735569475aa8ebd003557c598e.jpg') ,
(3, 'Longing for Peace', '', '6aaa6d9ba4e77aced6f6a1243f91d189.jpg') ,
(4, 'Pathfinders Touch', '', '6f95560ef99099383cc90a7c97d6e7c5.jpg') ,
(5, 'Merman Brawler', '', '18e9b964776bbe6c9f6842f1feba8b8b.jpg') ,
(6, 'Doubt of Violence', '', '21deac7ac82cb90751d565167538e7ff.jpg') ,
(7, 'Elvish Archer', '', '32ffbefc4281baef0b70ae3c376d0774.jpg') ,
(8, 'Seasons Provision', '', '42afaf9ff8bcf8a59c00a9ad69343a34.jpg') ,
(9, 'Camoflage Coat', '', '52f8d315707e029ea4f368cffeb03989.jpg') ,
(10, 'Thunder Arkbalist', '', '66c1847a4c4a33303bbf295af8a821ba.jpg') ,
(11, 'Bound by Love', '', '78dd96c06603cc16477b913222fc7388.jpg') ,
(12, 'Sharp Shooter', '', '84bb51addd8e145f3dffa1da7a392c98.jpg') ,
(13, 'Elvish Shaman', '', '207ba984070bfdedf138d6513b3b9057.jpg') ,
(14, 'Elvish Scout', '', '271f77b48827ad0dfb0dbd7b5805d8d3.jpg') ,
(15, 'Algea Armor', '', '787b8e750f4436e8bd4eff8ce9122c5a.jpg') ,
(16, 'Arknym Half-Tree', '', '52194ccdfc65104b3fdc56d48a07f292.jpg') ,
(17, 'Green Shield', '', '682740aebbdf8af3df3ff7c3212d52d0.jpg') ,
(18, 'Elvish Marksman', '', '8459945aaac3e485b963a3a40ff66bd1.jpg') ,
(19, 'Elvish Captain', '', 'b2df35112667ae2d09fe2995f4d3aa67.jpg') ,
(20, 'Elvish Ranger', '', 'c13acdf59c0bba52db8b964023deee3c.jpg') ,
(21, 'Merman Hoplite', '', 'ccdb9cd145e39ee22df8a09c51458645.jpg') ,
(22, 'Serenity', '', 'dce7e0fb11c3cce0898d9529c9fac76b.jpg') ,
(23, 'Elvish Fighter', '', 'e9693f365494e18113d6d661a94c4b7a.jpg') ,
(24, 'Elvish Druid', '', 'f87c27cffe62777a2c0d9d251024d1b2.jpg') ;

INSERT INTO `DeckCard`(`cardId`, `deckId`)
VALUES (1, 1), (2, 1), (3, 1), (4, 1), (5, 1), (6, 1), (7, 1), (8, 1), (9, 1), 
(10, 1), (11, 1), (12, 1), (13, 1), (14, 1), (15, 1), (16, 1), (17, 1), (18, 1), 
(19, 1), (20, 1), (21, 1), (22, 1), (23, 1), (24, 1) ;


INSERT INTO `Game`(`gameId`, `player1`, `created`, `deck1`)
VALUES (1, 1, NOW(), 1 ) ;
