<?php

/**
 * TODO: document this
 */
class SCContainer {

    /**
     *
     * @var SCGame 
     */
    private $game;
    private $id;
    private $movable = false;
    private $droppable = false;
    private $max;
    protected $elements;
    private $parent = null;
    // @var float location inside parent, in percentage
    private $xOffset = 0;
    private $yOffset = 0;
    // @var boolean 
    private $invertYOffset = false;

    public function __construct(SCGame $game, $movable, $droppable, $max = null) {
        $this->game = $game;
        $this->setId(uniqid('sc'));
        $this->movable = $movable;
        $this->droppable = $droppable;

        $this->elements = array();
    }

    public function __wakeup() {
        $this->invertYOffset = false;
    }

    public function setId($id) {
        if ($this->id)
            $this->game->unregister($this);
        $this->id = $id;
        $this->game->register($this);
    }

    public function getId() {
        return $this->id;
    }

    public function push(SCCard $scCard, $xOffset = 0, $yOffset = 0) {
        if ($this->max === null || count($this->elements < $this->max)) {
            array_push($this->elements, $scCard);
            $scCard->setParent($this);
            $scCard->setXOffset($xOffset);
            $scCard->setYOffset($yOffset);
            return true;
        }
        else
            return false;
    }

    public function remove(SCCard $card) {
        $pos = array_search($card, $this->elements, true);
        if ($pos !== false) {
            unset($this->elements[$pos]);
            $card->setXOffset(0);
            $card->setYOffset(0);
            return $card;
        }
        else
            return null;
    }

    /**
     * 
     * @return SCCard
     */
    public function pop() {
        $e = array_pop($this->elements);
        if ($e) {
            $e->setParent(null);
            $e->setXOffset(0);
            $e->setYOffset(0);
        }
        return $e;
    }

    public function getRoot() {
        $o = $this;
        while ($o->getParent())
            $o = $o->getParent();
        return $this->game->getRoot($o);
    }

    public function getParent() {
        return $this->parent;
    }

    public function setParent($parent) {
        $this->parent = $parent;
    }

    public function getXOffset() {
        return $this->xOffset;
    }

    public function setXOffset($xOffset) {
        $this->xOffset = $xOffset;
    }

    public function getYOffset() {
        return $this->yOffset;
    }

    public function setYOffset($yOffset) {
        $this->yOffset = $yOffset;
    }

    public function isMovable() {
        return $this->movable;
    }

    public function setMovable($movable) {
        $this->movable = $movable;
    }

    public function setDropable($droppable) {
        $this->droppable = $droppable;
    }

    public function isDroppable() {
        return $this->droppable;
    }

    public function getZIndex() {
        return 50;
    }

    public function setInvertYOffset($invertYOffset) {
        $this->invertYOffset = $invertYOffset;
    }

    public function invertY() {
        $o = $this;
        while ($o) {
            if ($o->invertYOffset)
                return true;
            $o = $o->getParent();
        }
        return false;
    }

    public function getStatus() {
        $root = $this->getRoot();

        return (object) array(
                    'id' => $this->getId(),
                    'location' => ($root && $this->getParent() ? $this->getParent()->getId() : $this->game->getVoid()->getId()),
                    'xOffset' => $this->getXOffset(),
                    'yOffset' => $this->getYOffset(),
                    'invertY' => $this->invertY(),
                    'zIndex' => $this->getZIndex()
        );
    }

    /**
     * Checks if the container is inside the other container
     * @param SCContainer $container 
     * @return boolean
     */
    public function isInside(SCContainer $container) {
        $o = $this;
        while ($o->getParent()) {
            if ($o === $container)
                return true;
            $o = $o->getParent();
        }
        return false;
    }

    public function __toString() {
        return 'ID: ' . $this->id . ', isMovable: ' . ($this->movable ? 'true' : 'false')
                . ', isDroppable: ' . ($this->droppable ? 'true' : 'false') . ', max of '
                . $this->max . ', element count: ' . count($this->elements);
    }

}