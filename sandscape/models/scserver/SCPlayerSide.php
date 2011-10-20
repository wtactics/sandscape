<?php


class SCPlayerSide
{
   private $playerId;
   private $decks;
   private $graveyard;
   private $hand;
   private $playableArea;

   public function __construct($playerId, $decks, $hasGraveyard, $handWidth, $handHeight, $gameWidth, $gameHeight)
   {
      $this->playerId = $playerId;
      $this->hand = new SCGrid($handHeight, $handWidth);
      $this->playableArea = new SCGrid($gameHeight, $gameWidth);
      if ($hasGraveyard) $this->graveyard = new SCContainer();

      $this->decks = $decks;
   }

   public function getPlayerId()
   {
      return $this->playerId;
   }

   public function findCardContainer($id)
   {
      //$container = $this->deck->findCardContainer($id);
      //if (!$container)
      //    $container = $this->graveyard->findCardContainer($id);
      //if (!$container)
      //    $container = $this->hand->findCardContainer($id);
      //if (!$container)
      //    $container = $this->playableArea->findCardContainer($id);
      //return $container;
   }

   public function find($id)
   {
      //$obj = $this->deck->find($id);
      //if (!$obj)
      //    $obj = $this->graveyard->find($id);
      //if (!$obj)
      //    $obj = $this->hand->find($id);
      //if (!$obj)
      //    $obj = $this->playableArea->find($id);
      //return $obj;
   }

   //public function getDeck() {
   //    return $this->deck;
   //}
   
   public function getGraveyard() {
       return $this->graveyard;
   }
   
   public function getHand() {
       return $this->hand;
   }
   public function getPlayableArea() {
       return $this->playableArea;
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