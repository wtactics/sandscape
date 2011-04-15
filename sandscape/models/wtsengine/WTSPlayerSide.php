<?php


/**
 * Class: WTSPlayerSide
 *
 * @author serra
 */
class WTSPlayerSide
{
   private $deck;
   private $graveyard;
   private $hand;
   private $playableArea;

   /**
    *
    * @param array $deck      WTSCard array
    */
   public function __construct($deck)
   {
      $this->deck = new WTSStack(false, false);
      $this->graveyard = new WTSStack(false, true);
      $this->hand = new WTSGrid(10, 10);
      $this->playableArea = new WTSGrid(30, 70);

      foreach ($deck as $card) $this->deck->push($card);
   }

   public function findCardContainer($id)
   {
      $container = $this->deck->findCardContainer($id);
      if (!$container) $container = $this->graveyard->findCardContainer($id);
      if (!$container) $container = $this->hand->findCardContainer($id);
      if (!$container) $container = $this->playableArea->findCardContainer($id);
      return $container;
   }

   public function find($id)
   {
      $obj = $this->deck->find($id);
      if (!$obj) $obj = $this->graveyard->find($id);
      if (!$obj) $obj = $this->hand->find($id);
      if (!$obj) $obj = $this->playableArea->find($id);
      return $obj;
   }

   public function getDeck()
   {
      return $this->deck;
   }

   public function getGraveyard()
   {
      return $this->graveyard;
   }

   public function getHand()
   {
      return $this->hand;
   }

   public function getPlayableArea()
   {
      return $this->playableArea;
   }

}

?>