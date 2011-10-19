<?php

class SCCard {

    private $face;
    private $back;
    private $states;
    private $tokens;

    public function __construct($face, $back = 'cardback.jpg') {
        $this->face = $face;
        $this->back = $back;
        $this->states = array();
        $this->tokens = array();
    }

    public function addToken(SCToken $token) {
        
    }

    public function removeToken(SCToken $token) {
        
    }

}