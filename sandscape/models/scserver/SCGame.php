<?php

class SCGame {

    private $all = array();
    private $roots = array();
    private $availableTokens = array();
    private $availableStates = array();

    /**
     *
     * @var SCPlayerSide 
     */
    private $player1Side;

    /**
     *
     * @var SCPlayerSide 
     */
    private $player2Side;

    /**
     * If a card is not anywhere, is in void
     * @var SCContainer
     */
    private $void;

    /**
     * TODO: document this....
     */
    public function __construct($hasGraveyard, $player1, $player2, $availableTokens, $availableStates, $handWidth = 20, $handHeight = 20, $gameWidth = 100, $gameHeight = 30) {
        $this->player1Side = new SCPlayerSide($this, $player1, $hasGraveyard, $handWidth, $handHeight, $gameWidth, $gameHeight);
        $this->player2Side = new SCPlayerSide($this, $player2, $hasGraveyard, $handWidth, $handHeight, $gameWidth, $gameHeight);
        $this->void = new SCContainer($this, false, false);

        foreach ($availableTokens as $token)
            $this->availableTokens[$token->getId()] = $token;

        foreach ($availableStates as $state)
            $this->availableStates[$state->getId()] = $state;
    }

    public function __wakeup() {
        $this->roots = array();
    }

    public function register(SCContainer $c) {
        $this->all[$c->getId()] = $c;
    }

    public function unregister(SCContainer $c) {
        unset($this->all[$c->getId()]);
    }

    public function getRoot(SCContainer $scc) {
        if (isset($this->roots[$scc->getId()]))
            return $this->roots[$scc->getId()];
        return null;
    }

    public function addPlayer1Deck(SCDeck $deck) {
        $this->player1Side->addDeck($deck);
    }

    public function addPlayer2Deck(SCDeck $deck) {
        $this->player2Side->addDeck($deck);
    }

    /**
     * Returns the current player side
     * 
     * @param  int          $userId     User who originated the reques
     * @return SCPlayerSide 
     */
    public function getPlayerSide($userId) {
        $side = ($this->player1Side->getPlayerId() == $userId ? $this->player1Side :
                        ($this->player2Side->getPlayerId() == $userId ? $this->player2Side : null));

        $this->roots[$side->getHand()->getId()] = $side->getHand();
        $this->roots[$side->getPlayableArea()->getId()] = $side->getPlayableArea();
        if ($side->getGraveyard())
            $this->roots[$side->getGraveyard()->getId()] = $side->getGraveyard();
        foreach ($side->getDecks() as $deck)
            $this->roots[$deck->getId()] = $deck;

        return $side;
    }

    /**
     * Returns the opponent side of the game
     * @param  int          $userId     User who originated the reques
     * @return SCPlayerSide
     */
    public function getOpponentSide($userId) {
        $side = ($this->player1Side->getPlayerId() == $userId ? $this->player2Side :
                        ($this->player2Side->getPlayerId() == $userId ? $this->player1Side : null));

        $this->roots [$side->getPlayableArea()->getId()] = $side->getPlayableArea();
        $side->getPlayableArea()->setInvertYOffset(true);

        return $side;
    }

    public function getVoid() {
        return $this->void;
    }

    /**
     * Returns the cards initialization
     * @return array
     */
    public function getCardInitialization() {
        $update = array();

        foreach ($this->all as $c) {
            if ($c instanceof SCCard) {
                $update [] = $c->getStatus();
            }
        }

        return $update;
    }

    /**
     * Returns all elements positions
     * 
     * I have the feeling that this one will try to bite me in the ass later.... 
     * 
     * @return array
     */
    public function getGameStatus() {
        $update = array();

        foreach ($this->all as $c) {
            if ($c->isMovable()) {
                $update [] = $c->getStatus();
            }
        }

        return $update;
    }

    public function drawCard($userId, $deck) {
        $player = $this->getPlayerSide($userId);
        $opponent = $this->getOpponentSide($userId);

        $player->drawCard($deck);

        return (object) array(
                    'update' => $this->getGameStatus()
        );
    }

    public function moveCard($userId, $card, $location, $xOffset = 0, $yOffset = 0) {
        $player = $this->getPlayerSide($userId);
        $opponent = $this->getOpponentSide($userId);

        $card = isset($this->all[$card]) ? $this->all[$card] : null;
        $location = isset($this->all[$location]) ? $this->all[$location] : null;

        if ($card && $location && $card instanceof SCCard && $card->isMovable() && $location->isDroppable() && $card->getPlayer() == $userId) {
            if ($card !== $location && !$location->isInside($card)) {
                if ($card->getParent())
                    $oldLocation = $card->getParent();
                if ($location->push($card) && $oldLocation) {
                    $oldLocation->remove($card);
                }
            }
            if ($card) {
                $card->setXOffset($xOffset);
                $card->setYOffset($yOffset);
            }
        }

        return (object) array(
                    'update' => $this->getGameStatus()
        );
    }

    public function toggleCardToken($userId, $card, $token) {
        $player = $this->getPlayerSide($userId);
        $opponent = $this->getOpponentSide($userId);

        $card = isset($this->all[$card]) ? $this->all[$card] : null;
        $token = isset($this->availableTokens[$token]) ? $this->availableTokens[$token] : null;

        if ($card && $token && $card instanceof SCCard && $card->getPlayer() == $userId) {
            $card->toggleToken($token);

            return (object) array(
                        'update' => $this->getGameStatus()
            );
        }
    }

    public function toggleCardState($userId, $card, $state) {
        $player = $this->getPlayerSide($userId);
        $opponent = $this->getOpponentSide($userId);

        $card = isset($this->all[$card]) ? $this->all[$card] : null;
        $state = isset($this->availableStates[$state]) ? $this->availableStates[$state] : null;

        if ($card && $state && $card instanceof SCCard && $card->getPlayer() == $userId) {
            $card->toggleState($state);

            return (object) array(
                        'update' => $this->getGameStatus()
            );
        }
    }

    public function clientUpdate($userId) {
        $player = $this->getPlayerSide($userId);
        $opponent = $this->getOpponentSide($userId);

        return (object) array(
                    'update' => $this->getGameStatus()
        );
    }

    public function clientInitialization($userId) {
        $player = $this->getPlayerSide($userId);
        $opponent = $this->getOpponentSide($userId);

        $tokens = array();
        foreach ($this->availableTokens as $token)
            $tokens [] = $token->getInfo();

        $states = array();
        foreach ($this->availableStates as $state)
            $states[] = $state->getInfo();

        return (object) array(
                    'createThis' => (object) array(
                        'nowhere' => (object) array(
                            'id' => $this->void->getId(),
                        ),
                        'player' => (object) array(
                            'hand' => (object) array(
                                'id' => $player->getHand()->getId(),
//                              'html' => $player->getHand()->getHTML(),
                            ),
                            'playableArea' => (object) array(
                                'id' => $player->getPlayableArea()->getId(),
//                              'html' => $player->getPlayableArea()->getHTML(),
                            ),
                            'decks' => $player->getDecksInitialization(),
                            'graveyard' => $player->getGraveyard() ? (object) array(
                                        'id' => $player->getGraveyard()->getId(),
                                    ) : null,
                        ),
                        'opponent' => (object) array(
                            'playableArea' => (object) array(
                                'id' => $opponent->getPlayableArea()->getId(),
//                              'html' => $opponent->getPlayableArea()->getReversedHTML(),
                            )
                        ),
                        'cards' => $this->getCardInitialization(),
                    ),
                    'gameInfo' => (object) array(
                        'tokens' => $tokens,
                        'cardStates' => $states
                    )
        );
    }

    public static function JSONIndent($json) {
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

    /**
     * Returns the database ID for the card that has the given internal ID.
     * 
     * @param string $cardId The ID used to identify the <em>SCCard</em> object and for 
     * which we want the corresponding <em>Card</em> object ID.
     * @return integer The database ID if the card exists, zero otherwise
     */
    public function getCardDBId($cardId) {
        if (isset($this->all[$cardId])) {
            return $this->all[$cardId]->getDbId();
        }

        return 0;
    }

}