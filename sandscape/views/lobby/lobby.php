<?php
$updUrl = $this->createUrl('lobby/lobbyupdate');
$sendUrl = $this->createUrl('lobby/sendmessage');

$last = 0;
if (count($messages)) {
    $last = end($messages);
    $last = $last->messageId;
}
//
Yii::app()->clientScript->registerCoreScript('jquery.ui');
//
Yii::app()->clientScript->registerCssFile('_resources/css/sandscape/lobby.' . (YII_DEBUG ? '' : '.min') . 'css');
Yii::app()->clientScript->registerCssFile('_resources/css/sandscape/modal.' . (YII_DEBUG ? '' : '.min') . 'css');
Yii::app()->clientScript->registerScriptFile('_resources/js/sandscape/lobby.' . (YII_DEBUG ? '' : '.min') . 'js');
Yii::app()->clientScript->registerScriptFile('_resources/js/thirdparty/jquery.simplemodal.1.4.1.min.js');

$js = <<<JS
globals.lastReceived = {$last};
globals.urls.upd = '{$updUrl}';
globals.urls.send = '{$sendUrl}';

initLobby();

JS;

Yii::app()->clientScript->registerScript('msgsjs', $js);

$this->title = 'Sandscape Lobby';
?>

<h2>Lobby</h2>

<div id="users-area">
    <?php
    $this->widget('zii.widgets.jui.CJuiSlider', array(
        'id' => 'users-slider',
        'options' => array(
            'value' => 100,
            'animate' => true,
            'orientation' => 'vertical',
            'slide' => 'js:usersSliderScroll',
            'change' => 'js:usersSliderChange'
        )
    ));
    ?>
    <div id="users-view">
        <ul id="users-list">
            <?php foreach ($users as $user) { ?>
                <li>
                    <a href="<?php echo $this->createURL((Yii::app()->user->id != $user->userId ? 'account/profile' : '/account'), array('id' => $user->userId)); ?>">
                        <?php echo $user->name; ?>
                    </a>
                </li>
            <?php } ?>
        </ul>
    </div>
</div>

<div id="chat-area">
    <?php
    $this->widget('zii.widgets.jui.CJuiSlider', array(
        'id' => 'chat-slider',
        'options' => array(
            'max' => 0,
            'animate' => true,
            'orientation' => 'vertical',
            'slide' => 'js:chatSliderScroll',
            'change' => 'js:chatSliderChange',
            'create' => 'js:chatSliderSetValue'
        )
    ));
    ?>
    <div id="chat-view">
        <ul id="messages-list">
            <?php foreach ($messages as $message) { ?>
                <li>
                    <strong><?php echo $message->user->name; ?>:</strong>&nbsp;
                    <?php echo CHtml::encode($message->message); ?>
                </li>
            <?php } ?>
        </ul>
    </div>
</div>

<div id="games-area">
    <?php
    if ($cardCount != 0) {

        $this->widget('zii.widgets.jui.CJuiSlider', array(
            'id' => 'games-slider',
            'options' => array(
                'value' => 100,
                'animate' => true,
                'orientation' => 'vertical',
                'slide' => 'js:gamesSliderScroll',
                'change' => 'js:gamesSliderChange'
            )
        ));
        ?>
        <div id="games-view">
            <ul id="games-list">
                <?php
                $currentId = Yii::app()->user->id;
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
        </div>
    <?php } else { ?>
        <div style="text-align: center; vertical-align: middle;">There are no cards to play with!</div>
    <?php } ?>
</div>

<div class="clearfix"></div>

<div id="lobbytools">
    <div id="messagetools">
        <input type="text" class="text" id="writemessage" />

        <button type="button" class="button" onclick="sendMessage();" id="sendbtn">Send</button>
    </div>
    <div id="gametools">
        <?php if ($cardCount != 0) { ?>
            <a href="javascript:;" onclick="$('#createdlg').modal();" class="button">Create Game</a>

            <?php
            echo CHtml::label('Filter Games:', 'filterGames'), '&nbsp;&nbsp;&nbsp;',
            CHtml::dropDownList('filterGames', null, array(
                0 => 'All',
                1 => 'Paused',
                2 => 'Running',
                3 => 'That I play',
                4 => 'Waiting for me',
                5 => 'Waiting for opponent'
                    ), array('onchange' => 'filterGameList();')
            );
        }
        ?>
    </div>
    <div class="clearfix"></div>
</div>

<div style="display: none">
    <?php
    $this->renderPartial('_createdlg', array(
        'decks' => $decks,
        'fixDeckNr' => $fixDeckNr,
        'decksPerGame' => $decksPerGame
    ));

    $this->renderPartial('_joindlg', array(
        'decks' => $decks
    ));

    $this->renderPartial('_spectatedlg');
    ?>
</div>