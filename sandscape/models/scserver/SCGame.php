<?php


class SCGame
{
   private $all = array();
   private $roots = array();

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
   public function __construct($hasGraveyard, $player1, $player2, $handWidth = 10, $handHeight = 10, $gameWidth = 50, $gameHeight = 15)
   {
      $this->player1Side = new SCPlayerSide($this, $player1, $hasGraveyard, $handWidth, $handHeight, $gameWidth, $gameHeight);
      $this->player2Side = new SCPlayerSide($this, $player2, $hasGraveyard, $handWidth, $handHeight, $gameWidth, $gameHeight);
      $this->void = new SCContainer($this, false, false);
   }

   public function __wakeup()
   {
      $this->roots = array();
   }

   public function register(SCContainer $c)
   {
      $this->all[$c->getId()] = $c;
   }

   public function unregister(SCContainer $c)
   {
      unset($this->all[$c->getId()]);
   }
   
   public function getRoot(SCContainer $scc)
   {
      if (isset($this->roots[$scc->getId()])) return $this->roots[$scc->getId()];
      return null;
   }

   public function addPlayer1Deck(SCDeck $deck)
   {
      $this->player1Side->addDeck($deck);
   }

   public function addPlayer2Deck(SCDeck $deck)
   {
      $this->player2Side->addDeck($deck);
   }

   /**
    * Returns the current player side
    * 
    * @param  int          $userId     User who originated the reques
    * @return SCPlayerSide 
    */
   public function getPlayerSide($userId)
   {
      $side = ($this->player1Side->getPlayerId() == $userId ? $this->player1Side :
                  ($this->player2Side->getPlayerId() == $userId ? $this->player2Side : null));

      $this->roots[$side->getHand()->getId()] = $side->getHand();
      $this->roots[$side->getPlayableArea()->getId()] = $side->getPlayableArea();
      if ($side->getGraveyard()) $this->roots[$side->getGraveyard()->getId()] = $side->getGraveyard();
      foreach ($side->getDecks() as $deck) $this->roots[$deck->getId()] = $deck;

      return $side;
   }

   /**
    * Returns the opponent side of the game
    * @param  int          $userId     User who originated the reques
    * @return SCPlayerSide
    */
   public function getOpponentSide($userId)
   {
      $side = ($this->player1Side->getPlayerId() == $userId ? $this->player2Side :
                  ($this->player2Side->getPlayerId() == $userId ? $this->player1Side : null));
      
      $this->roots [$side->getPlayableArea()->getId()] = $side->getPlayableArea();

      return $side;
   }

   public function getVoid()
   {
      return $this->void;
   }
   
   /**
    * Returns the cards initialization
    * @return array
    */
   public function getCardInitialization()
   {
      $update = array();
      
      foreach($this->all as $c)
      {
         if ($c instanceof SCCard)
         {
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
   public function getGameStatus()
   {
      $update = array();
      
      foreach($this->all as $c)
      {
         if ($c->isMovable())
         {
            $update [] = $c->getStatus();
         }
      }
      
      return $update;
   }
   
   public function drawCard($userId, $deck)
   {
      $player = $this->getPlayerSide($userId);
      $opponent = $this->getOpponentSide($userId);
      
      $player->drawCard($deck);
      
      return (object) array(
          'update' => $this->getGameStatus()
      );
   }
   
   public function moveCard($userId, $card, $location)
   {
      $player = $this->getPlayerSide($userId);
      $opponent = $this->getOpponentSide($userId);
      
      $card = isset($this->all[$card]) ? $this->all[$card] : null;
      $location = isset($this->all[$location]) ? $this->all[$location] : null;
      
      if ($card  &&  $location  &&  $card instanceof SCCard  &&  $card->isMovable()  &&  $location->isDroppable())
      {
         if ($card->getParent()) $oldLocation = $card->getParent();
         if ($location->push($card)  &&  $oldLocation) $oldLocation->remove($card);
      }
      
      return (object) array(
          'update' => $this->getGameStatus()
      );
   }
   
   public function clientUpdate($userId)
   {
      $player = $this->getPlayerSide($userId);
      $opponent = $this->getOpponentSide($userId);
      
      return (object) array(
            'update' => $this->getGameStatus()
      );
   }

   public function clientInitialization($userId)
   {
      $player = $this->getPlayerSide($userId);
      $opponent = $this->getOpponentSide($userId);

      return (object) array(
                  'createThis' => (object) array(
                        'nowhere' => (object) array(
                              'id' => $this->void->getId(),
                        ),
                        'player' => (object) array(
                              'hand' => (object) array(
                                    'id' => $player->getHand()->getId(),
                                    'html' => $player->getHand()->getHTML(),
                              ),
                              'playableArea' => (object) array(
                                    'id' => $player->getPlayableArea()->getId(),
                                    'html' => $player->getPlayableArea()->getHTML(),
                              ),
                              'decks' => $player->getDecksInitialization(),
                              'graveyard' => $player->getGraveyard() ? (object) array(
                                          'id' => $player->getGraveyard()->getId(),
                                    ) : null,
                        ),
                        'opponent' => (object) array(
                              'playableArea' => (object) array(
                                    'id' => $opponent->getPlayableArea()->getId(),
                                    'html' => $opponent->getPlayableArea()->getReversedHTML(),
                              )
                        ),
                        'cards' => $this->getCardInitialization(),
                  )
      );
   }

   public static function JSONIndent($json)
   {
      $result = '';
      $pos = 0;
      $strLen = strlen($json);
      $indentStr = '  ';
      $newLine = "\n";
      $prevChar = '';
      $outOfQuotes = true;

      for ($i = 0; $i <= $strLen; $i++)
      {

         // Grab the next character in the string.
         $char = substr($json, $i, 1);

         // Are we inside a quoted string?
         if ($char == '"' && $prevChar != '\\')
         {
            $outOfQuotes = !$outOfQuotes;

            // If this character is the end of an element,
            // output a new line and indent the next line.
         }
         else if (($char == '}' || $char == ']') && $outOfQuotes)
         {
            $result .= $newLine;
            $pos--;
            for ($j = 0; $j < $pos; $j++)
            {
               $result .= $indentStr;
            }
         }

         // Add the character to the result string.
         $result .= $char;

         // If the last character was the beginning of an element,
         // output a new line and indent the next line.
         if (($char == ',' || $char == '{' || $char == '[') && $outOfQuotes)
         {
            $result .= $newLine;
            if ($char == '{' || $char == '[')
            {
               $pos++;
            }

            for ($j = 0; $j < $pos; $j++)
            {
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