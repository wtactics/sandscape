
-- Remove old deck references
alter table Game drop foreign key fkGameDeck1;
alter table Game drop foreign key fkGameDeck2;
alter table Game drop key fkGameDeck1;
alter table Game drop key fkGameDeck2;
alter table Game drop deck1;
alter table Game drop deck2;

-- add max number of decks per player
alter table Game add maxDecks tinyint not null default 1;

-- the game has a graveyard?
alter table Game add graveyard tinyint not null default 1;

-- players are ready
alter table Game
add player1Ready tinyint not null default 0,
add player2Ready tinyint not null default 0;

-- create Game / Deck link
create table GameDeck
(
   gameId int unsigned not null,
   deckId int unsigned not null,
   primary key (gameId, deckId),
   constraint fkGameDeckGame foreign key (gameId) references Game(gameId),
   constraint fkGameDeckDeck foreign key (deckId) references Deck(deckId)
) ENGINE = InnoDB CHARACTER SET utf8 COLLATE utf8_unicode_ci ;


drop table DeckCard;
create table DeckCard (
   dcId     int unsigned primary key auto_increment,
   deckId   int unsigned not null,
   cardId   int unsigned not null,
   constraint fkDCDeck foreign key (deckId) references Deck(deckId),
   constraint fkDCCard foreign key (cardId) references Card(cardId)
) engine=InnoDB character set utf8 collate utf8_unicode_ci;

