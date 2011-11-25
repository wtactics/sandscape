<?php
$last = 0;
if (count($messages)) {
    $last = end($messages);
    $last = $last->messageId;
}

Yii::app()->clientScript->registerCssFile('_resources/css/sandscape/game.common' . (YII_DEBUG ? '' : '.min') . '.css');
Yii::app()->clientScript->registerCssFile('_resources/css/sandscape/game.play' . (YII_DEBUG ? '' : '.min') . '.css');
Yii::app()->clientScript->registerCssFile('_resources/css/sandscape/modal.' . (YII_DEBUG ? '' : '.min') . 'css');
//
Yii::app()->clientScript->registerCoreScript('jquery.ui');
//
Yii::app()->clientScript->registerScriptFile('_resources/js/thirdparty/jquery.jgrowl.min.js', CClientScript::POS_HEAD);
Yii::app()->clientScript->registerScriptFile('_resources/js/thirdparty/jquery.simplemodal.1.4.1.min.js', CClientScript::POS_HEAD);
Yii::app()->clientScript->registerScriptFile('_resources/js/sandscape/game.play' . (YII_DEBUG ? '' : '.min') . '.js', CClientScript::POS_HEAD);
Yii::app()->clientScript->registerScriptFile('_resources/js/thirdparty/jquery.radialmenu.min.js', CClientScript::POS_HEAD);

$playUrl = $this->createURL('game/play', array('id' => $gameId));
$sendMessageUrl = $this->createUrl('game/sendmessage', array('id' => $gameId));
$updateMessageUrl = $this->createUrl('game/chatupdate', array('id' => $gameId));

$startJS = <<<JS
globals.chat.sendUrl = '{$sendMessageUrl}';
globals.chat.updateUrl = '{$updateMessageUrl}';
globals.chat.lastReceived = {$last};
globals.game.url = '{$playUrl}';
globals.user.id = {$user->id};
globals.user.name = '{$user->name}';
    
init();

JS;
Yii::app()->clientScript->registerScript('startjs', $startJS);

$this->title = 'Playing';
?>

<div id="left-column">
    <div id="card-info">
        <div class="big-label" style="display:none;"></div>
        <img id="card-image" src="_game/cards/cardback.jpg" />
    </div>
    <div id="chat">
        <?php
        $this->widget('zii.widgets.jui.CJuiSlider', array(
            'id' => 'chat-slider',
            'options' => array(
                'max' => 0,
                'animate' => true,
                'orientation' => 'vertical',
                'slide' => 'js:sliderScroll',
                'change' => 'js:sliderChange',
                'create' => 'js:sliderSetValue'
            )
        ));
        ?>
        <div id="content-view">
            <ul id="chat-messages">
                <?php
                foreach ($messages as $message) {
                    if ($message->system) {
                        ?>
                        <li class="system-message <?php echo ($player1 == $message->userId ? 'player1-action' : 'player2-action'); ?>">
                            <strong>
                                <?php echo date('H:i', strtotime($message->sent)); ?>:
                            </strong>
                            <?php echo $message->message; ?>
                        </li>
                    <?php } else { ?>
                        <li class="user-message <?php echo ($player1 == $message->userId ? 'player1-text' :
                        ($player2 == $message->userId ? 'player2-text' : 'spectator-text')); ?>">
                            <strong><?php echo date('H:i', strtotime($message->sent)); ?>:</strong>
                            <?php echo $message->message; ?>
                        </li>
                    <?php }
                } ?>
            </ul>
        </div>
        <input type="text" id="writemessage" />
    </div>
    <div class="hand"><!-- PLAYER HAND AREA --></div>
</div>
<div class="opponent-area"><!-- OPPONENT GAME AREA --></div>
<div class="play"><!-- PLAYER 1 GAME AREA --></div>

<!-- EXTRA DOM ELEMENTS -->

<!-- LOADER DIVS -->
<div id="opponent-loader" class="loader" style="display:none;">
    <img id="img-loader" src="_resources/images/game-loader.gif" />
    <br />
    <span>Waiting for opponent.</span>
</div>

<div id="game-loader" class="loader" style="display:none;">
    <img id="img-loader" src="_resources/images/game-loader.gif" />
    <br />
    <span>Building game.</span>
</div>

<!-- IN-GAME MENU -->
<img id="menu-slider" src="_resources/images/game-slider-nob.png" />
<div id="menu-wrapper">
    <div id="menu-header">
        <img src="_resources/images/game-slider-title.png" />
    </div>
    <div id="menu-content">
        <div id="game-menu">
            <h2>Game Menu</h2>
            <ul id="menu-elements">
                <?php if (count($dice)) { ?>
                    <li>
                        <a href="javascript:;" class="list-header">Dice &Gt;</a>
                        <ul class="sub-menu">
                            <?php foreach ($dice as $die) { ?>
                                <li><a href="javascript:roll(<?php echo $die->diceId; ?>)"><?php echo $die->name; ?></a></li>
                            <?php } ?>
                        </ul>
                    </li>
                <?php } ?>
                <li>
                    <a href="javascript:;" class="list-header">Chat Messages &Gt;</a>
                    <ul class="sub-menu">
                        <li><?php echo Chtml::checkBox('show-user-messages', true, array('onchange' => 'filterChatMessages()')); ?> User</li>
                        <li><?php echo Chtml::checkBox('show-system-messages', true, array('onchange' => 'filterChatMessages()')); ?> System</li>
                    </ul>
                </li>
                <li><a href="javascript:exit();">Exit</a></li>
            </ul>
        </div>
        <br />
        <h2>Player Counters</h2>
        <!--
        //TODO: not implemented yet!
        <div id="player-counters">
            <h3>Counters</h3>
            <div id="pc-area"><!-- PLAYER COUNTERS ARE PLACED HERE --><!--</div>
        </div> -->
        <h2>Decks</h2>
        <div id="decks"><!-- DECKS ARE PLACED HERE --></div>
    </div>
</div>

<!-- DIALOG DIVS -->
<div style="display:none;">
    <?php
    $this->renderPartial('_labeldlg');

    $this->renderPartial('_cardcounterdlg');

    $this->renderPartial('_exitdlg', array('gameId' => $gameId));
    ?>
</div>