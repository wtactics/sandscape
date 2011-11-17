<?php
$updUrl = $this->createUrl('game/chatupdate');
$sendUrl = $this->createUrl('game/sendmessage');

$last = 0;
if (count($messages)) {
    $last = end($messages);
    $last = $last->messageId;
}

Yii::app()->clientScript->registerCssFile('_resources/css/sandscape/lobby.' . (YII_DEBUG ? '' : '.min') . 'css');
Yii::app()->clientScript->registerCssFile('_resources/css/sandscape/modal.' . (YII_DEBUG ? '' : '.min') . 'css');
Yii::app()->clientScript->registerScriptFile('_resources/js/sandscape/lobby.' . (YII_DEBUG ? '' : '.min') . 'js');
Yii::app()->clientScript->registerScriptFile('_resources/js/thirdparty/jquery.simplemodal.1.4.1.min.js');

Yii::app()->clientScript->registerScript('msgsjs', "initLobby({$last}, '{$updUrl}', '{$sendUrl}');");

$this->title = 'Sandscape Lobby';
?>

<h2>Lobby</h2>
<div class="span-4">
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
                        <a href="<?php echo $this->createURL((Yii::app()->user->id != $user->userId ? 'user/view' : 'user/profile'), array('id' => $user->userId)); ?>">
                            <?php echo $user->name; ?>
                        </a>
                    </li>
                <?php } ?>
            </ul>
        </div>
    </div>
</div>
<div class="span-11">
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
            //'create' => 'js:sliderSetValue'
            )
        ));
        ?>
        <div id="chat-view">
            <ul id="messages-list">
                <?php foreach ($messages as $message) { ?>
                    <li>
                        <span>
                            <strong><?php echo $message->user->name; ?></strong>
                            [<?php echo Yii::app()->dateFormatter->formatDateTime(strtotime($message->sent), 'short'); ?>]:
                        </span>
                        <br />
                        <?php echo CHtml::encode($message->message); ?>
                    </li>
                <?php } ?>
            </ul>
        </div>
    </div>
</div>
<div class="span-7 last">
    <div id="games-area">
        <?php
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
                foreach ($games as $game) {
                    if (in_array(Yii::app()->user->id, array($game->player1, $game->player2)) && !$game->ended) {
                        $class = 'success';
                        if (!$game->running) {
                            $class = 'notice';
                        }
                        ?>
                        <li class="<?php echo $class; ?>">
                            <span>
                                <a href="<?php echo $this->createURL('game/play', array('id' => $game->gameId)); ?>">Return to Game</a>
                                &nbsp;-&nbsp;
                                <?php echo date('d/m/Y H:m', strtotime($game->created)); ?>
                            </span>
                            <br />
                            <?php if ($game->player2) { ?>
                                <span>Opponent: 
                                    <?php
                                    echo CHtml::link((Yii::app()->user->id == $game->player1 ?
                                                    $game->player20->name : $game->player10->name)
                                            , $this->createUrl('account/profile', array('id' => Yii::app()->user->id == $game->player1 ?
                                                        $game->player2 : $game->player1)));
                                    ?>
                                </span>
                            <?php } else { ?>
                                <span>No opponent yet.</span>
                            <?php } ?>
                        </li>
                        <?php
                    } else {
                        $class = 'error';
                        if ($game->running) {
                            $class = 'success spectate';
                        } else if (!$game->player2) {
                            $class = 'info join';
                        }
                        ?>
                        <li class="<?php echo $class; ?>">
                            <input type="hidden" class="hGameId" value="<?php echo $game->gameId; ?>" name="gameId-<?php echo $game->gameId; ?>" />
                            <input type="hidden" class="hGameDM" value="<?php echo $game->maxDecks; ?>" name="gameDM-<?php echo $game->gameId; ?>" />
                            <span><?php echo date(DATE_W3C, strtotime($game->created)); ?></span>
                            <br />
                            <?php if ($game->running) { ?>
                                <span><?php echo $game->player10->name, '&nbsp;-&nbsp;', $game->player20->name; ?></span>
                            <?php } else { ?>
                                <span>Create by <?php echo $game->player10->name; ?></span>
                            <?php } ?>
                        </li>
                        <?php
                    }
                }
                ?>
            </ul>
        </div>
    </div>
</div>
<hr />
<div class="span-4">
    <a href="javascript:;" onclick="$('#createdlg').modal();" class="button">Create Game</a>
</div>
<div class="span-11 centered">
    <input type="text" class="text" id="writemessage" />
    <button type="button" class="button" onclick="sendMessage();" id="sendbtn">Send</button>
</div>
<div class="span-7 last">
    <?php echo CHtml::dropDownList('filterGames', null, array()); ?>
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