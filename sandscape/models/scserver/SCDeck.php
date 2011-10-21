<?php


/**
 * Class: SCDeck
 *
 * @author serra
 */
class SCDeck extends SCContainer
{
   private $name;
   
   public function __construct(SCGame $game, $name, $cards)
   {
      parent::__construct($game, false, false);
      $this->name = $name;
      
      foreach($cards as $c) $this->push ($c);
   }
   
   public function getName() {
      return $this->name;
   }

}

?>