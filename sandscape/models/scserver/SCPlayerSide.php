<?php

class SCPlayerSide {

   private $game;
   private $playerId;
   private $decks;
   private $graveyard;
   private $hand;
   private $playableArea;

   public function __construct(SCGame $game, $playerId, $hasGraveyard, $handWidth, $handHeight, $gameWidth, $gameHeight) {
      $this->game = $game;
      $this->playerId = $playerId;
      $this->hand = new SCGrid($game, $handHeight, $handWidth);
      $this->playableArea = new SCGrid($game, $gameHeight, $gameWidth);
      if ($hasGraveyard)
         $this->graveyard = new SCContainer($game, false, false);

      $this->decks = array();
   }

   public function addDeck(SCDeck $deck) {
      $this->decks[$deck->getId()] = $deck;
   }

   public function getPlayerId() {
      return $this->playerId;
   }

   public function getGraveyard() {
      return $this->graveyard;
   }

   public function getHand() {
      return $this->hand;
   }

   public function getPlayableArea() {
      return $this->playableArea;
   }

   public function getDecks() {
      return $this->decks;
   }

   public function getDecksInitialization() {
      $output = array();
      foreach ($this->decks as $deck) {
         $output [] = (object) array(
                     'id' => $deck->getId(),
                     'name' => $deck->getName(),
         );
      }
      return $output;
   }

   public function drawCard($deckId) {
//      die('died in '.get_class($this).' at ' . time() . '  ' . var_export($_REQUEST, true));
      if (isset($this->decks[$deckId])) {
         $deck = $this->decks[$deckId];
         $card = $deck->pop();
         if ($card) {
            $card->setFaceUp(true);
            $card->setMovable(true);
            $this->hand->push($card);
         }
      }
   }

}