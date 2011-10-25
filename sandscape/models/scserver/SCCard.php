<?php

class SCCard extends SCContainer {

   private $dbId;
   private $face;
   private $back;
   private $faceUp = false;
   private $player;

//   private $states;
//   private $tokens;

   public function __construct(SCGame $game, $player, $dbId, $face, $back = 'cardback.jpg') {
      parent::__construct($game, false, true, 1);
      $this->player = $player;
      $this->dbId = $dbId;
      $this->face = $face;
      $this->back = $back;
//      $this->states = array();
//      $this->tokens = array();
   }

//
//   public function addToken(SCToken $token)
//   {
//      
//   }
//
//   public function removeToken(SCToken $token)
//   {
//      
//   }

   public function getPlayer() {
      return $this->player;
   }

   public function isFaceUp() {
      return $this->faceUp;
   }

   public function setFaceUp($faceUp) {
      $this->faceUp = $faceUp;
   }

   public function getSrc() {
      if ($this->isFaceUp())
         return $this->face;
      else
         return $this->back;
   }

   public function getStatus() {
      $status = parent::getStatus();
      $status->src = $this->getSrc();
      return $status;
   }

   /**
    * Returns the database ID for this card.
    * 
    * @return integer
    */
   public function getDbId() {
      return $this->dbId;
   }

}