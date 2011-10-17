INSERT INTO `User`(`userId`, `email`, `password`, `name`, `admin`)
VALUES (1, 'knitter@wtactics.org', SHA1('demo'), 'Knitter', 1) ;

INSERT INTO `Deck`(`deckId`, `name`, `userId`, `created`)
VALUES (1, 'Grave Digger', 1, NOW()) ;

INSERT INTO `Card`(`cardId`, `name`, `rules`, `image`, `cardscapeId`)
VALUES (1, '', '', '', ) ,
(1, '', '', '', ) ,
(1, '', '', '', ) ,
(1, '', '', '', ) ,
(1, '', '', '', ) ,
(1, '', '', '', ) ,
(1, '', '', '', ) ,
(1, '', '', '', ) ,
(1, '', '', '', ) ,
(1, '', '', '', ) ,
(1, '', '', '', ) ,
(1, '', '', '', ) ,
(1, '', '', '', ) ,
(1, '', '', '', ) ,
(1, '', '', '', ) ,
(1, '', '', '', ) ;

INSERT INTO `DeckCard`(`cardId`, `deckId`)
VALUES (, 1), (, 1), (, 1), (, 1), (, 1), (, 1), (, 1), (, 1), (, 1), (, 1), (, 1), (, 1) ;


INSERT INTO `Game`(`gameId`, `player1`, `created`, `deck1`)
VALUES (1, 1, NOW(), 1 ) ;
