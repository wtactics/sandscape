-- Testing users
INSERT INTO `User`(`userId`, `email`, `password`, `name`, `admin`)
VALUES (1, 'knitter@wtactics.org', SHA1('demoDemo, development hash, please change this in a production server'), 'Knitter', 1),
(2, 'afonso@sandscape.moc', SHA1('demoDemo, development hash, please change this in a production server'), 'Afonso Goncalves Baldaia', 0),
(3, 'alvaro@sandscape.moc', SHA1('demoDemo, development hash, please change this in a production server'), 'Alvaro Martins', 0), 
(4, 'andre@sandscape.moc', SHA1('demoDemo, development hash, please change this in a production server'), 'Andre Goncalves ', 0), 
(5, 'antonio@sandscape.moc', SHA1('demoDemo, development hash, please change this in a production server'), 'Antonio Fernandes', 0), 
(6, 'diogo@sandscape.moc', SHA1('demoDemo, development hash, please change this in a production server'), 'Diogo Cao', 0) ;

-- Decks, 4 decks for the first 4 users
INSERT INTO `Deck`(`deckId`, `name`, `userId`, `created`)
VALUES (1, 'Grave Digger', 1, NOW()), (2, 'Pacifier', 2, NOW()), 
(3, 'My Deck', 3, NOW()), (4, 'Gaians', 4, NOW()) ;

-- Existing demo cards
INSERT INTO `Card`(`cardId`, `name`, `image`, `cardscapeId`, `rules`)
VALUES (1, 'Livin Tree', '0faee65bce7f5bbfad77cdb00a8e0414.jpg', 29, 'Every unused resource pile becomes a Tree Creature until end of turn with x/x, where X is the amount of resources in the RP. Discard one resource card from the RP for each 2 damage it receives.'),
(2, 'Dryads Flute', '1b5df7735569475aa8ebd003557c598e.jpg', 27, 'Remove target non-Gaian attacker from combat before it\'s defender is declared. It remains marked'),
(3, 'Longing for Peace', '6aaa6d9ba4e77aced6f6a1243f91d189.jpg', 33, 'Until end of current turn and the next players turn no attackers can be declared in target front.'),
(4, 'Pathfinders Touch', '6f95560ef99099383cc90a7c97d6e7c5.jpg', 52,'Target creature gets Pathfinder - Only creatures with Flying or Ranged can defend against Pathfinder.'),
(5, 'Merman Brawler', '18e9b964776bbe6c9f6842f1feba8b8b.jpg', 23, 'Whenever Merman Brawler damages an enemy place a stun token on that enemy. When the enemy would be unmarked and while there are stun tokens on it, remove a stun token instead of unmarking it.'),
(6, 'Doubt of Violence', '21deac7ac82cb90751d565167538e7ff.jpg', 26, 'Target attacker is placed on top of its owners Army Deck. If it costs 3 or less and it has no local attacking allies it is discarded instead. All damage to the defender(s) is resolved as normal.'),
(7, 'Elvish Archer', '32ffbefc4281baef0b70ae3c376d0774.jpg', 5, 'Ranged (This unit can defend against units with Flying.) Offensive Strike - Defenders only strike back if they survive.'),
(8, 'Seasons Provision', '42afaf9ff8bcf8a59c00a9ad69343a34.jpg', 8, '	Sacrifice Seasons Provision: Prevent all damage that was dealt to its carrier during this turn.'),
(9, 'Camoflage Coat', '52f8d315707e029ea4f368cffeb03989.jpg', 30 ,'Equipped creature gets +1/+0 when defending. While it is not defending it has +0/+1.'),
(10, 'Thunder Arkbalist', '66c1847a4c4a33303bbf295af8a821ba.jpg', 50, 'When Thunder Arkbalist attacks, mark target ally. Discard Thunder Arkbalist if the marked creature is discarded the same turn it marked. Offensive strike. Ranged'),
(11, 'Bound by Love', '78dd96c06603cc16477b913222fc7388.jpg', 39, 'Target an ally. Search your deck for a Gaian Creature with a cost of 3 or less and place it local to the ally for free. The creature will follow the ally wherever it\'s placed. Movement marks it as usual.'),
(12, 'Sharp Shooter', '84bb51addd8e145f3dffa1da7a392c98.jpg', 9, 'Ranged (This creature may defend against flying creatures) When there are no local allies Elvish Sharpshooter may attack a creature instead of a player.'),
(13, 'Elvish Shaman', '207ba984070bfdedf138d6513b3b9057.jpg', 1, '[m]: Prevent up to 2 damage to target creature.'),
(14, 'Elvish Scout', '271f77b48827ad0dfb0dbd7b5805d8d3.jpg', 6, 'Quick (This creature does not mark when moving and may move twice).'),
(15, 'Algea Armor', '787b8e750f4436e8bd4eff8ce9122c5a.jpg', 4, 'Equipped creature gets +0/+2. If it is a Merfolk it also gets "Guard (This creature can defend against multiple attackers.)"'),
(16, 'Arknym Half-Tree', '52194ccdfc65104b3fdc56d48a07f292.jpg',49, 'While in combat Arknym Half-tree can only die if it has been dealt damage by a Caster, Legend or Leader. Arknym Half-tree may not get its combat stats made greater in any way.'),
(17, 'Green Shield', '682740aebbdf8af3df3ff7c3212d52d0.jpg', 25, 'Prevent all damage to target defender. It also gets +1/+0 until end of battle.'),
(18, 'Elvish Marksman', '8459945aaac3e485b963a3a40ff66bd1.jpg',8, 'Offensive Strike (Enemy defender only strikes back in combat if it survives.) (m), 1: Deal 1 damage to target attacker that is being defended against by an ally. '),
(19, 'Elvish Captain', 'b2df35112667ae2d09fe2995f4d3aa67.jpg', 32, 'All ally Gaian creatures gain +0/+1 while defending. [m]:Unmark target ally.'),
(20, 'Elvish Ranger', 'c13acdf59c0bba52db8b964023deee3c.jpg', 10, 'Stealth 2 (Only creatures with a gold cost of 2 or more can defend against this creature).'),
(21, 'Merman Hoplite', 'ccdb9cd145e39ee22df8a09c51458645.jpg', 21, '	Guard (This creature can defend against multiple attackers).'),
(22, 'Serenity', 'dce7e0fb11c3cce0898d9529c9fac76b.jpg', 40, 'Target combating non-Gaian creature doesn\'t unmark next turn.'),
(23, 'Elvish Fighter', 'e9693f365494e18113d6d661a94c4b7a.jpg', 3, ''),
(24, 'Elvish Druid', 'f87c27cffe62777a2c0d9d251024d1b2.jpg', 11, '[m]: Target creatures attack is reduced to half (rounded up) until end of turn. [m]: Target creature can\'t move until end of turn.') ,
(25, 'Soulharvester', '7fffa40bac33ea522ee93da8c35c095c.png', 7, 'Once per turn, when an ally non-token creature of cost 3 or lower would be put in the graveyard, you may instead place it as a Resource Card on your smallest Resource Pile.') ;

-- Make cards belong to decks
INSERT INTO `DeckCard`(`cardId`, `deckId`)
VALUES (1, 1), (2, 1), (3, 1), (4, 1), (5, 1), (6, 1), (7, 1), (8, 1), (9, 1), 
(10, 1), (11, 1), (12, 1), (13, 1), (14, 1), (15, 1), (16, 1), (17, 1), (18, 1), 
(19, 1), (20, 1), (21, 1), (22, 1), (23, 1), (24, 1), (25, 1),
--
(1, 2), (2, 2), (3, 2), (4, 2), (5, 2), (6, 2), (7, 2), (8, 2), (9, 2), 
(10, 2), (11, 2), (12, 2), (13, 2), (14, 2), (15, 2), (16, 2), (17, 2), (18, 2), 
(19, 2), (20, 2), (21, 2), (22, 2), (23, 2), (24, 2), (25, 2),
--
(1, 3), (2, 3), (3, 3), (4, 3), (5, 3), (6, 3), (7, 3), (8, 3), (9, 3), 
(10, 3), (11, 3), (12, 3), (13, 3), (14, 3), (15, 3), (16, 3), (17, 3), (18, 3), 
(19, 3), (20, 3), (21, 3), (22, 3), (23, 3), (24, 3), (25, 3),
--
(1, 4), (2, 4), (3, 4), (4, 4), (5, 4), (6, 4), (7, 4), (8, 4), (9, 4), 
(10, 4), (11, 4), (12, 4), (13, 4), (14, 4), (15, 4), (16, 4), (17, 4), (18, 4), 
(19, 4), (20, 4), (21, 4), (22, 4), (23, 4), (24, 4), (25, 4) ;

-- Create some games
-- INSERT INTO `Game`(`gameId`, `player1`, `player2`, `created`, `started`, `ended`, `running`, `deck1`, `deck2`, `private`)
-- VALUES (1, 1, NULL, NOW(), NULL, NULL, 0, 1, NULL, 0), 
-- (2, 2, 3, NOW(), NOW(), NULL, 1, 2, 3, 0),
-- (3, 4, NULL, NOW(), NULL, NULL, 0, 4, NULL, 0) ;

-- Place some messages in lobby
INSERT INTO `ChatMessage` (`messageId`, `message`, `userId`)
VALUES (1, 'Hey!', 1), (2, 'Everybody ready for a new game?', 2) , 
(3, 'Here, lets start on', 1), (4, 'I can\'t, already playing...', 3) , 
(5, 'I\'ve just created a new game, feel free to join', 1) ;