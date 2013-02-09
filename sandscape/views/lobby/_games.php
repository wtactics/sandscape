<div id="games-area" class="well">
    <div id="games-view">
        <!--
        <?php /* if ($cardCount != 0) {

          $this->widget('zii.widgets.jui.CJuiSlider', array(
          'id' => 'games-slider',
          'options' => array(
          'value' => 100,
          'animate' => true,
          'orientation' => 'vertical',
          'slide' => 'js:gamesSliderScroll',
          'change' => 'js:gamesSliderChange'
          )
          )); */ ?>
                ?>
               <ul id="games-list">
        <?php /* $currentId = Yii::app()->user->id;
          foreach ($games as $game) {
          $created = date('d/m/Y H:i', strtotime($game->created));
          if (!$game->running) {
          if ($game->acceptUser == $currentId) {
          ?>
          <!-- //join game for you -->
          <li class="info join wait-me">
          <strong>[<?php echo $game->gameId; ?>] <?php echo $created; ?></strong>
          <br />
          <?php echo $game->creator->name; ?> is waiting for you to join.
          </li>
          <?php
          } else if (!in_array($currentId, array($game->player1, $game->player2))) {
          ?>
          <!-- //join game -->
          <li class="info join wait-opponent">
          <strong>[<?php echo $game->gameId; ?>] <?php echo $created; ?></strong>
          <br />
          <?php echo $game->creator->name; ?> is waiting for opponents.
          <input type="hidden" class="hGameId" value="<?php echo $game->gameId; ?>" name="gameId-<?php echo $game->gameId; ?>" />
          <input type="hidden" class="hGameDM" value="<?php echo $game->maxDecks; ?>" name="gameDM-<?php echo $game->gameId; ?>" />
          </li>
          <?php
          } else {
          ?>
          <!-- //return to game -->
          <li class="notice return my-game<?php echo (!$game->player2 ? ' wait-opponent' : ''); ?>">
          <strong>[<?php echo $game->gameId; ?>] <?php echo $created; ?></strong>
          <br />
          <?php
          if ($game->player1 == $currentId) {
          if ($game->player2) {
          echo 'Return to game with ', $game->opponent->name, '.';
          } else {
          echo 'Return and wait for opponent to join.';
          }
          } else {
          echo 'Return to game with ', $game->creator->name, '.';
          }
          ?>
          <input type="hidden" class="hGameUrl" value="<?php echo $this->createUrl('game/play', array('id' => $game->gameId)); ?>" />
          </li>
          <?php
          }
          } else if ($game->paused) {
          if (!in_array($currentId, array($game->player1, $game->player2))) {
          ?>
          <!-- //can't do anything -->
          <li class="error paused">
          <img src="_resources/images/icon-x16-control-pause.png" style="float:right"/>
          <strong>[<?php echo $game->gameId; ?>] <?php echo $created; ?></strong>
          <br />
          Game between <?php echo $game->creator->name, ' and ', $game->opponent->name; ?> is paused.
          </li>
          <?php } else { ?>
          <!--//return to game -->
          <li class="notice return paused my-game">
          <img src="_resources/images/icon-x16-control-pause.png" style="float:right"/>
          <strong>[<?php echo $game->gameId; ?>] <?php echo $created; ?></strong>
          <br />
          Return to game with <?php echo ($currentId == $game->player1 ? $game->opponent->name : $game->creator->name); ?>
          <input type="hidden" class="hGameUrl" value="<?php echo $this->createUrl('game/play', array('id' => $game->gameId)); ?>" />
          </li>
          <?php
          }
          } else {
          if (in_array($currentId, array($game->player1, $game->player2))) {
          ?>
          <!-- //return to game -->
          <li class="notice return running my-game">
          <strong>[<?php echo $game->gameId; ?>] <?php echo $created; ?></strong>
          <br />
          Return to game with <?php echo ($currentId == $game->player1 ? $game->opponent->name : $game->creator->name); ?>
          <input type="hidden" class="hGameUrl" value="<?php echo $this->createUrl('game/play', array('id' => $game->gameId)); ?>" />
          </li>
          <?php
          } else {
          ?>
          <!-- //watch game -->
          <li class="success spectate running">
          <strong>[<?php echo $game->gameId; ?>] <?php echo $created; ?></strong>
          <br />
          <?php echo $game->creator->name; ?> is battling <?php echo $game->opponent->name; ?>
          <input type="hidden" class="hGameId" value="<?php echo $game->gameId; ?>" name="gameId-<?php echo $game->gameId; ?>" />
          </li>
          <?php
          }
          }
          }
          ?>
          </ul>
          <?php } else { ?>
          <div style="text-align: center; vertical-align: middle;">There are no cards to play with!</div>
          <?php } */ ?>
        -->
    </div>
</div>