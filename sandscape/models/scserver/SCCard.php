<?php


class SCCard extends SCContainer
{
   private $id;
   private $face;
   private $back;
//   private $states;
//   private $tokens;

   public function __construct($id, $face, $back = 'cardback.jpg')
   {
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