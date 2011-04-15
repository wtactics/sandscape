<?php

class WTSGame {

    private $playerASide;
    private $playerBSide;
    //TODO: //NOTE: ...
    private $started;

    public function __construct() {
        //WTSCard::$defaultFaceDown = myURL() . '/images/cards/CardBack.png';
        $this->started = false;
    }

    public function getPlayerASide() {
        return $this->playerASide;
    }

    public function getPlayerBSide() {
        return $this->playerBSide;
    }

    public function init($playerADeck, $playerBDeck) {

        if (!$this->started) {
            $cards = array();
            foreach ($playerADeck->cards as $card) {
                $cards[] = new WTSCard($card);
            }
            $this->playerASide = new WTSPlayerSide($cards);


            $cards = array();
            foreach ($playerBDeck->cards as $card) {
                $cards[] = new WTSCard($card);
            }
            $this->playerBSide = new WTSPlayerSide($cards);

            $this->started = true;
        }
    }
    
    public function isStarted() {
        return $this->started;
    }

}

?>