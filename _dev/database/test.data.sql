INSERT INTO `User` (`name`, `email`, `password`)
VALUES ('user1', 'user1@someplace.moc', SHA1('demo')) ,
('user2', 'user2@someplace.moc', SHA1('demo')) ,
('user3', 'user3@someplace.moc', SHA1('demo')) ,
('user4', 'user4@someplace.moc', SHA1('demo')) ;

INSERT INTO `Card` (`name`, `description`, `file`)
VALUES ('card 1', 'none', 'none'), ('card 2', 'none', 'none'), ('card 3', 'none', 'none'),
('card 4', 'none', 'none'), ('card 5', 'none', 'none'), ('card 6', 'none', 'none'),
('card 7', 'none', 'none'), ('card 8', 'none', 'none'), ('card 9', 'none', 'none') ;

INSERT INTO `Deck` (`name`, `created`, `userId`)
VALUES ('Mighty', NOW(), 1), ('Decky', NOW(), 2) ;
 
INSERT INTO`Game` (`start`, `deckIdPlayerA`, `deckIdPlayerB`, `userIdPlayerA`, `userIdPlayerB`)
VALUES(NOW(), 1, 2, 1, 2);

INSERT INTO `DeckCard` (`deckId`, `cardId`)
VALUES(1, 1), (1, 2), (1, 3), (1, 4), (2, 5), (2, 6), (2, 7), (2, 8) ;