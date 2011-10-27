<?php

class SCCard extends SCContainer {

   private $dbId;
   private $face;
   private $back;
   private $faceUp = false;
   private $player;
   private $states;
   private $tokens;

   public function __construct(SCGame $game, $player, $dbId, $face, $back = 'cardback.jpg') {
      parent::__construct($game, false, true, 1);
      $this->player = $player;
      $this->dbId = $dbId;
      $this->face = $face;
      $this->back = $back;
      $this->states = array();
      $this->tokens = array();
   }

   public function addToken(SCToken $token) {
      $this->tokens[$token->getId()] = $token;
   }

   public function removeToken(SCToken $token) {
      unset($this->tokens[$token->getId()]);
   }
   
   public function addState(SCState $state) {
      $this->states[$state->getId()] = $state;
   }
   
   public function removeState(SCState $state) {
      unset($this->stated[$state->getId()]);
   }

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
      if ($this->isFaceUp() && $this->getRoot())
         return $this->face;
      else
         return $this->back;
   }

   public function getVisibility() {
      $o = $this->getParent();
      while ($o) {
         if ($o instanceof SCDeck)
            return 'hidden';
         $o = $o->getParent();
      }
      return 'visible';
   }
   
   public function getStatus() {
      $status = parent::getStatus();
      $status->src = $this->getSrc();
      $status->visibility = $this->getVisibility();
      
      $status->tokens = array();
      foreach($this->tokens as $token) $status->tokens [] = $token->getJSONData();
      
      $status->states = array();
      foreach($this->states as $state) $status->states[] = $state->getJSONData();
      
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

   public function getZIndex() {
      $z = 50;
      $o = $this;
      while ($o) {
         $o = $o->getParent();
         $z++;
      }
      return $z;
   }

}