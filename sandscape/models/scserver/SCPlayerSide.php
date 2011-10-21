<?php


class SCPlayerSide
{
   private $game;
   private $playerId;
   private $decks;
   private $graveyard;
   private $hand;
   private $playableArea;

   public function __construct(SCGame $game, $playerId, $hasGraveyard, $handWidth, $handHeight, $gameWidth, $gameHeight)
   {
      $this->game = $game;
      $this->playerId = $playerId;
      $this->hand = new SCGrid($game, $handHeight, $handWidth);
      $this->playableArea = new SCGrid($game, $gameHeight, $gameWidth);
      if ($hasGraveyard) $this->graveyard = new SCContainer($game, false, false);

      $this->decks = array();
   }
   
   public function addDeck(SCDeck $deck)
   {
      $this->decks[] = $deck;
   }

   public function getPlayerId()
   {
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
   
   public function getDecks()
   {
      return $this->decks;
   }
   
   public function getDecksInitialization()
   {
      $output = array();
      foreach($this->decks as $deck)
      {
         $output [] = (object) array('id' => $deck->getId());
      }
      return $output;
   }
   
}