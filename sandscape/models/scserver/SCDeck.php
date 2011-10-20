<?php


/**
 * Class: SCDeck
 *
 * @author serra
 */
class SCDeck extends SCContainer
{
   private $name;
   
   public function __construct($name, $cards)
   {
      parent::__construct(false, false);
      $this->name = $name;
      
      foreach($cards as $c) $this->push ($c);
   }
}

?>