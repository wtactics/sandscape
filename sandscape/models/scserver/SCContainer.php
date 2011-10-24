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

    public function __construct(SCGame $game, $movable, $droppable, $max = null) {
        $this->game = $game;
        $this->setId(uniqid('sc'));
        $this->movable = $movable;
        $this->droppable = $droppable;

        $this->elements = array();
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

    public function push(SCCard $scCard) {
        if ($this->max === null || count($this->elements < $this->max)) {
            array_push($this->elements, $scCard);
            $scCard->setParent($this);
            return true;
        }
        else
            return false;
    }

    public function remove(SCCard $card) {
        $pos = array_search($card, $this->elements, true);
        if ($pos !== false) {
            unset($this->elements[$pos]);
            return $card;
        }
        else
            return null;
    }

    /**
     * //TODO: ...
     * 
     * @return SCCard
     */
    public function pop() {
        $e = array_pop($this->elements);
        if ($e)
            $e->setParent(null);
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

    public function getStatus() {
        $root = $this->getRoot();

        return (object) array(
                    'id' => $this->getId(),
                    'location' => ($root && $this->getParent() ? $this->getParent()->getId() : $this->game->getVoid()->getId()),
                    'offsetHeight' => ( $this->getParent() && $this->getParent()->isMovable() ? 1 : 0)
        );
    }

    public function __toString() {
        return 'ID: ' . $this->id . ', isMovable: ' . ($this->movable ? 'true' : 'false')
                . ', isDroppable: ' . ($this->droppable ? 'true' : 'false') . ', max of '
                . $this->max . ', element count: ' . count($this->elements);
    }

}