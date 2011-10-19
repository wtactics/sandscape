<?php

class SCPlayerSide {

    private $playerId;
    private $deck;
    private $graveyard;
    private $hand;
    private $playableArea;

    /**
     *
     * @param Deck $deck 
     */
    public function __construct($deck, $rows = 30, $cols = 70) {
        $this->playerId = $deck->userId;
        $this->hand = new SCGrid(10, 10);
        $this->playableArea = new SCGrid($rows, $cols);

        $this->deck = array();
        foreach ($deck->deckCards as $dc) {
            //TODO: $this->deck[] = ...
        }
    }

    public function getPlayerId() {
        return $this->playerId;
    }

    public function findCardContainer($id) {
        //$container = $this->deck->findCardContainer($id);
        //if (!$container)
        //    $container = $this->graveyard->findCardContainer($id);
        //if (!$container)
        //    $container = $this->hand->findCardContainer($id);
        //if (!$container)
        //    $container = $this->playableArea->findCardContainer($id);
        //return $container;
    }

    public function find($id) {
        //$obj = $this->deck->find($id);
        //if (!$obj)
        //    $obj = $this->graveyard->find($id);
        //if (!$obj)
        //    $obj = $this->hand->find($id);
        //if (!$obj)
        //    $obj = $this->playableArea->find($id);
        //return $obj;
    }

    //public function getDeck() {
    //    return $this->deck;
    //}
    //public function getGraveyard() {
    //    return $this->graveyard;
    //}
    //public function getHand() {
    //    return $this->hand;
    //}
    //public function getPlayableArea() {
    //    return $this->playableArea;
    //}
}