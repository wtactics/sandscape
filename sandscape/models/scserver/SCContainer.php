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

//    public function getCard($id) {
//        foreach ($this->elements as $e)
//            if ($e instanceof WTSCard && $e->getId() == $id)
//                return $e;
//    }
//
//    public function removeCard($id) {
//        foreach ($this->elements as $i => $e)
//            if ($e instanceof WTSCard && $e->getId() == $id) {
//                unset($this->elements[$i]);
//                return $e;
//            }
//    }
//
//    public function getUpdate() {
//        $output = array();
//        foreach ($this->elements as $e)
//            if ($e instanceof WTSCard) {
//                $output [] = $e->jsonCreate($this->getId());
//                $output [] = $e->jsonImage();
////            $output [] = $e->jsonActive();
//                $output [] = $e->jsonMove($this->getId());
//                $output = array_merge($output, $e->getUpdate());
//            }
//        return $output;
//    }
//
//    public function findCardContainer($id) {
//        foreach ($this->elements as $e) {
//            if ($e instanceof WTSCard && $e->getId() == $id)
//                return $this;
//            elseif ($e->findCardContainer($id))
//                return $e->findCardContainer($id);
//        }
//
//        return null;
//    }
//
//    public function find($id) {
//        if ($this->getId() == $id)
//            return $this;
//        foreach ($this->elements as $e) {
//            if ($e->getId() == $id)
//                return $e;
//            $result = $e->find($id);
//            if ($result)
//                return $result;
//        }
//        return null;
//    }
}