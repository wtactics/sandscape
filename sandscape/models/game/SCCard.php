<?php

class SCCard extends SCContainer {

    private $dbId;
    private $face;
    private $back;
    private $faceUp = false;
    private $player;
    private $states;
    private $tokens;
    private $label;

    /**
     *
     * @param SCGame $game
     * @param type $player
     * @param type $dbId
     * @param type $face
     * @param type $back 
     */
    public function __construct(SCGame $game, $player, $dbId, $face, $back = 'cardback-standard.png') {
        parent::__construct($game, false, true, 1);
        $this->player = $player;
        $this->dbId = $dbId;
        $this->face = $face;
        $this->back = $back;
        $this->states = array();
        $this->tokens = array();
        $this->counters = array();
    }

    public function getPlayer() {
        return $this->player;
    }

    public function isFaceUp() {
        return $this->faceUp;
    }

    public function setFaceUp($faceUp) {
        $this->faceUp = $faceUp;
    }

    public function getSrc() {
        if ($this->isFaceUp() && $this->getRoot())
            return $this->face;
        else
            return $this->back;
    }

    public function getVisibility() {
        //NOTE: Serra doesn't like this code, I don't blame him, but he wrote it!
        $o = $this->getParent();
        while ($o) {
            if ($o instanceof SCDeck || $o instanceof SCGraveyard) {
                return 'hidden';
            }

            $o = $o->getParent();
        }
        return 'visible';
    }

    public function getStatus() {
        $status = parent::getStatus();
        $status->src = $this->getSrc();
        $status->visibility = $this->getVisibility();

        $status->tokens = array();
        foreach ($this->tokens as $token) {
            $status->tokens [] = $token->getJSONData();
        }

        $status->states = array();
        foreach ($this->states as $state) {
            $status->states[] = $state->getJSONData();
        }

        $status->counters = array();
        foreach ($this->counters as $counter) {
            $status->counters[] = $counter->getJSONData();
        }

        $status->label = $this->label;
        return $status;
    }

    public function getDbId() {
        return $this->dbId;
    }

    public function getZIndex() {
        $z = 50;
        $o = $this;
        while ($o) {
            $o = $o->getParent();
            $z++;
        }
        return $z;
    }

    public function flip() {
        $this->faceUp = !$this->faceUp;
    }

}
