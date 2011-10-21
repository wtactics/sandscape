<?php


class SCCard extends SCContainer
{
   private $id;
   private $face;
   private $back;
   private $faceUp = false;

//   private $states;
//   private $tokens;

   public function __construct(SCGame $game, $id, $face, $back = 'cardback.jpg')
   {
      parent::__construct($game, false, true, 1);
      $this->id = $id;
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
   public function isFaceUp()
   {
      return $this->faceUp;
   }

   public function setFaceUp($faceUp)
   {
      $this->faceUp = $faceUp;
   }

   public function getSrc()
   {
      if ($this->isFaceUp()) return $this->face;
      else return $this->back;
   }
   
   public function getStatus()
   {
      $status = parent::getStatus();
      $status->src = $this->getSrc();
      return $status;
   }

}