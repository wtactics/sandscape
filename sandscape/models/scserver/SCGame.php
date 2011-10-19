<?php

class SCGame {

    /**
     *
     * @var SCPlayerSide 
     */
    private $playerASide;

    /**
     *
     * @var SCPlayerSide 
     */
    private $playerBSide;
    private $running;

    public function __construct($running = false) {
        $this->running = (bool) $running;
    }

    /**
     * //TODO: documentation ...
     * @param type $userId
     * @return SCPlayerSide 
     */
    public function getPlayerSide($userId) {
        return ($this->playerASide->getPlayerId() == $userId ? $this->playerASide :
                        ($this->playerBSide->getPlayerId() == $userId ? $this->playerBSide : null));
    }

    /**
     * //TODO: documentation ...
     * @param type $userId
     * @return SCPlayerSide
     */
    public function getOpponentSide($userId) {
        return ($this->playerASide->getPlayerId() == $userId ? $this->playerBSide :
                        ($this->playerBSide->getPlayerId() == $userId ? $this->playerASide : null));
    }

    public function isRunning() {
        return $this->running;
    }

    public function stop() {
        $this->running = false;
    }

    /**
     *
     * @param Deck $deckA
     * @param Deck $deckB 
     */
    public function init($deckA, $deckB) {
        if (!$this->running) {
            //TODO: create sides, create SCards for each side ...
            $this->running = true;
        }
    }

    private function JSONIndent($json) {
        $result = '';
        $pos = 0;
        $strLen = strlen($json);
        $indentStr = '  ';
        $newLine = "\n";
        $prevChar = '';
        $outOfQuotes = true;

        for ($i = 0; $i <= $strLen; $i++) {

            // Grab the next character in the string.
            $char = substr($json, $i, 1);

            // Are we inside a quoted string?
            if ($char == '"' && $prevChar != '\\') {
                $outOfQuotes = !$outOfQuotes;

                // If this character is the end of an element,
                // output a new line and indent the next line.
            } else if (($char == '}' || $char == ']') && $outOfQuotes) {
                $result .= $newLine;
                $pos--;
                for ($j = 0; $j < $pos; $j++) {
                    $result .= $indentStr;
                }
            }

            // Add the character to the result string.
            $result .= $char;

            // If the last character was the beginning of an element,
            // output a new line and indent the next line.
            if (($char == ',' || $char == '{' || $char == '[') && $outOfQuotes) {
                $result .= $newLine;
                if ($char == '{' || $char == '[') {
                    $pos++;
                }

                for ($j = 0; $j < $pos; $j++) {
                    $result .= $indentStr;
                }
            }

            $prevChar = $char;
        }

        return $result;
    }

}