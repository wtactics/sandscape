<?php


/**
 * Class: WTSCard
 *
 * @author serra
 */
class WTSCard extends WTSContainer
{
   public static $defaultFaceDown;
   private $card;
   private $urlFaceDown;
   private $faceUp = false;
   private $active = true;

   public function __construct($card)
   {
      parent::__construct(true, true);
      $this->card = $card;
      $this->urlFaceDown = self::$defaultFaceDown;
   }

   public function jsonCreate($idLocation)
   {
      return (object) array('f' => 'create', 'id' => $this->getId(), 'idLocation' => $idLocation);
   }

   public function jsonImage()
   {
       //TODO:... 
      //return (object) array('f' => 'image', 'id' => $this->getId(), 'src' => ($this->faceUp ? $this->url : $this->urlFaceDown));
   }

   public function jsonActive()
   {
      return (object) array('f' => 'active', 'id' => $this->getId(), 'active' => $this->active);
   }

   public function jsonMove($idDestination)
   {
      return (object) array('f' => 'move', 'id' => $this->getId(), 'idDestination' => $idDestination);
   }

   public function setFaceUp($faceUp)
   {
      $this->faceUp = $faceUp;
   }

}

?>