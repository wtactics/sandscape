<?php


/**
 * TODO: document this
 */
class SCContainer
{
   private $game;
   private $id;
   private $movable = false;
   private $dropable = false;
   private $max;
   protected $elements;
   private $parent = null;

   public function __construct(SCGame $game, $movable, $dropable, $max = null)
   {
      $this->game = $game;
      $this->setId(uniqid('sc'));
      $this->movable = $movable;
      $this->dropable = $dropable;

      $this->elements = array();
   }

   public function setId($id)
   {
      if ($this->id) $this->game->unregister ($this);
      $this->id = $id;
      $this->game->register($this);
   }

   public function getId()
   {
      return $this->id;
   }

   public function push(SCCard $scCard)
   {
      if ($this->max === null || count($this->elements < $this->max))
      {
         array_push($this->elements, $scCard);
         $scCard->setParent($this);
      }
   }

   /**
    * //TODO: ...
    * 
    * @return SCCard
    */
   public function pop()
   {
      $e = array_pop($this->elements);
      if ($e) $e->setParent(null);
      return $e;
   }
   
   public function getRoot()
   {
      $o = $this;
      while ($o->getParent()) $o = $o->getParent();
      return $this->game->getRoot($o);
   }

   public function getParent()
   {
      return $this->parent;
   }

   public function setParent($parent)
   {
      $this->parent = $parent;
   }
   
   public function isMovable()
   {
      return $this->movable;
   }
   
   public function setMovable($movable)
   {
      $this->movable = $movable;
   }

   public function setDropable($dropable)
   {
      $this->dropable = $dropable;
   }

   public function isDropable()
   {
      return $this->dropable;
   }

   public function getStatus()
   {
      $root = $this->getRoot();
      
      return (object) array(
            'id' => $this->getId(), 
            'location' => ($root && $this->getParent() ? $this->getParent()->getId() : $this->game->getVoid()->getId()),
            'ofsetHeight' => ( $this->getParent()  &&  $this->getParent()->isMovable() ? 1 : 0)
      );
   }
}