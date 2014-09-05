<?php

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
    private $invertView = false;

    public function __construct(SCGame $game, $movable, $droppable, $max = null) {
        $this->game = $game;
        $this->setId(uniqid('sc'));
        $this->movable = $movable;
        $this->droppable = $droppable;

        $this->elements = array();
    }

    public function __wakeup() {
        $this->invertView = false;
    }

    /**
     *
     * @param type $id 
     */
    public function setId($id) {
        if ($this->id)
            $this->game->unregister($this);
        $this->id = $id;
        $this->game->register($this);
    }

    /**
     *
     * @return type 
     */
    public function getId() {
        return $this->id;
    }

    /**
     *
     * @param SCCard $scCard
     * @param type $xOffset
     * @param type $yOffset
     * @return type 
     */
    public function push(SCCard $scCard, $xOffset = 0, $yOffset = 0) {
        if ($this->max === null || count($this->elements < $this->max)) {
            array_push($this->elements, $scCard);
            $scCard->setParent($this);
            $scCard->setXOffset($xOffset);
            $scCard->setYOffset($yOffset);
            return true;
        } else
            return false;
    }

    /**
     *
     * @param SCCard $card
     * @return SCCard 
     */
    public function remove(SCCard $card) {
        $pos = array_search($card, $this->elements, true);
        if ($pos !== false) {
            unset($this->elements[$pos]);
            $card->setXOffset(0);
            $card->setYOffset(0);
            return $card;
        }

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

    /**
     *
     * @return type 
     */
    public function getRoot() {
        $o = $this;
        while ($o->getParent())
            $o = $o->getParent();
        return $this->game->getRoot($o);
    }

    /**
     *
     * @return type 
     */
    public function getParent() {
        return $this->parent;
    }

    /**
     *
     * @param type $parent 
     */
    public function setParent($parent) {
        $this->parent = $parent;
    }

    /**
     *
     * @return type 
     */
    public function getXOffset() {
        return $this->xOffset;
    }

    /**
     *
     * @param type $xOffset 
     */
    public function setXOffset($xOffset) {
        $this->xOffset = $xOffset;
    }

    /**
     *
     * @return type 
     */
    public function getYOffset() {
        return $this->yOffset;
    }

    /**
     *
     * @param type $yOffset 
     */
    public function setYOffset($yOffset) {
        $this->yOffset = $yOffset;
    }

    /**
     *
     * @return bool
     */
    public function isMovable() {
        return $this->movable;
    }

    /**
     *
     * @param bool $movable 
     */
    public function setMovable($movable) {
        $this->movable = $movable;
    }

    /**
     *
     * @param bool $droppable 
     */
    public function setDropable($droppable) {
        $this->droppable = $droppable;
    }

    /**
     *
     * @return bool
     */
    public function isDroppable() {
        return $this->droppable;
    }

    /**
     *
     * @return int
     */
    public function getZIndex() {
        return 50;
    }

    /**
     *
     * @param bool $invertView 
     */
    public function setInvertView($invertView) {
        $this->invertView = $invertView;
    }

    /**
     *
     * @return bool
     */
    public function invertView() {
        $o = $this;
        while ($o) {
            if ($o->invertView) {
                return true;
            }
            $o = $o->getParent();
        }
        return false;
    }

    /**
     *
     * @return StdClass 
     */
    public function getStatus() {
        $root = $this->getRoot();

        return (object) array(
                    'id' => $this->getId(),
                    'location' => ($root && $this->getParent() ? $this->getParent()->getId() : $this->game->getVoid()->getId()),
                    'xOffset' => $this->getXOffset(),
                    'yOffset' => $this->getYOffset(),
                    'invertView' => $this->invertView(),
                    'zIndex' => $this->getZIndex()
        );
    }

    /**
     * Checks if the container is inside the other container.
     * 
     * @param SCContainer $container 
     * 
     * @return bool
     */
    public function isInside(SCContainer $container) {
        $o = $this;
        while ($o) {
            if ($o === $container)
                return true;
            $o = $o->getParent();
        }
        return false;
    }

    /**
     *
     * @return string
     */
    public function __toString() {
        return 'ID: ' . $this->id . ', isMovable: ' . ($this->movable ? 'true' : 'false')
                . ', isDroppable: ' . ($this->droppable ? 'true' : 'false') . ', max of '
                . $this->max . ', element count: ' . count($this->elements);
    }

    /**
     *
     * @return bool 
     */
    public function shuffle() {
        return shuffle($this->elements);
    }

}
