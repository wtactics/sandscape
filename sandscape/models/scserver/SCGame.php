<?php


class SCGame
{
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
    * TODO: document this....
    */
   public function __construct($hasGraveyard, $player1, $player2, $decksPlayer1, $decksPlayer2, $handWidth = 10, $handHeight = 10, $gameWidth = 70, $gameHeight = 30)
   {
      $this->player1Side = new SCPlayerSide($player1, $decksPlayer1, $hasGraveyard, $handWidth, $handHeight, $gameWidth, $gameHeight);
      $this->player2Side = new SCPlayerSide($player2, $decksPlayer2, $hasGraveyard, $handWidth, $handHeight, $gameWidth, $gameHeight);
   }

   /**
    * Returns the current player side
    * 
    * @param  int          $userId     User who originated the reques
    * @return SCPlayerSide 
    */
   public function getPlayerSide($userId)
   {
      return ($this->player1Side->getPlayerId() == $userId ? $this->player1Side :
                  ($this->player2Side->getPlayerId() == $userId ? $this->player2Side : null));
   }

   /**
    * Returns the opponent side of the game
    * @param  int          $userId     User who originated the reques
    * @return SCPlayerSide
    */
   public function getOpponentSide($userId)
   {
      return ($this->player1Side->getPlayerId() == $userId ? $this->player2Side :
                  ($this->player2Side->getPlayerId() == $userId ? $this->player1Side : null));
   }

   public function clientInitialization($userId)
   {
      $player = $this->getPlayerSide($userId);
      $opponent = $this->getOpponentSide($userId);
      
      $init = (object) array(
                  'structures' => (object) array(
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
                  ),
                  'status' => ''
      );
      return self::JSONIndent(json_encode($init));
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

}