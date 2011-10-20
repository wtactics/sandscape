<?php

/**
 * TODO: document this
 */

abstract class SCContainer {

    private $id;
    private $movable = false;
    private $dropable = false;
    private $max;
    protected $elements;

    public function __construct($movable, $dropable, $max = null) {
        $this->id = uniqid('scserver');
        $this->movable = $movable;
        $this->dropable = $dropable;

        $this->elements = array();
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function getId() {
        return $this->id;
    }

    public function push(SCCard $scCard) {
        if ($this->max === null || count($this->elements < $this->max))
            array_push($this->elements, $scCard);
    }

    /**
     * //TODO: ...
     * 
     * @return SCCard
     */
    public function pop() {
        return array_pop($this->elements);
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