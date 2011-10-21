<?php


class SCCard extends SCContainer
{
   private $id;
   private $face;
   private $back;
   private $faceUp = false;
//   private $states;
//   private $tokens;

   public function __construct(Game $game, $id, $face, $back = 'cardback.jpg')
   {
      parent::__construct($game, true, true);
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

}