<?php
$last = 0;
if (count($messages)) {
    $last = end($messages);
    $last = $last->messageId;
}

Yii::app()->clientScript->registerCssFile('_resources/css/sandscape/game.common.css');
Yii::app()->clientScript->registerCssFile('_resources/css/sandscape/game.play.css');
Yii::app()->clientScript->registerCssFile('_resources/css/thirdparty/jquery.bubblepopup.v2.3.1.css');
Yii::app()->clientScript->registerCssFile('_resources/css/thirdparty/jquery.jgrowl.css');
//
Yii::app()->clientScript->registerCoreScript('jquery.ui');
//
Yii::app()->clientScript->registerScriptFile('_resources/js/thirdparty/jquery.bubblepopup.v2.3.1.min.js', CClientScript::POS_HEAD);
Yii::app()->clientScript->registerScriptFile('_resources/js/thirdparty/jquery.jgrowl.minimized.js', CClientScript::POS_HEAD);
Yii::app()->clientScript->registerScriptFile('_resources/js/thirdparty/jquery.simplemodal.1.4.1.min.js', CClientScript::POS_HEAD);
Yii::app()->clientScript->registerScriptFile('_resources/js/sandscape/game.play.js', CClientScript::POS_HEAD);
Yii::app()->clientScript->registerScriptFile('_resources/js/thirdparty/jquery.radialmenu.min.js', CClientScript::POS_HEAD);

$playUrl = $this->createURL('game/play', array('id' => $gameId));
$sendMessageUrl = $this->createUrl('game/sendmessage', array('id' => $gameId));
$updateMessageUrl = $this->createUrl('game/chatupdate', array('id' => $gameId));

$startJS = <<<JS
globals.chat.sendUrl = '{$sendMessageUrl}';
globals.chat.updateUrl = '{$updateMessageUrl}';
globals.chat.lastReceived = {$last};
globals.game.url = '{$playUrl}';
globals.user = '{$user}';
    
init();

JS;
Yii::app()->clientScript->registerScript('startjs', $startJS);

$this->title = 'Playing';
?>

<div id="left-column">
    <div id="card-info">
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
                <?php foreach ($messages as $message) { ?>
                    <li class="user-message">
                        <strong><?php echo $message->user->name; ?></strong>: <?php echo $message->message; ?>
                    </li>
                <?php } ?>
            </ul>
        </div>
        <input type="text" id="writemessage" />
    </div>
    <div class="hand"><!-- PLAYER HAND AREA --></div>
</div>
<div class="opponent-area"><!-- OPPONENT GAME AREA --></div>

<div id="play-area">
    <div class="play"><!-- PLAYER CENTER AREA, CARD AREA --></div>

    <div id="deck-widget">
        <div id="deck-slide"><!-- DECK CONTAINER --></div>
    </div>                   
</div>

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
<div id="game-menu">
    <img id="menu-slider" src="_resources/images/game-menu-slider.png" />
    <ul id="menu-elements">
        <?php if (count($dice)) { ?>
            <li>
                <a href="javascript:;">Dice</a>
                <ul class="sub-menu">
                    <?php foreach ($dice as $die) { ?>
                        <li><a href="javascript:roll(<?php echo $die->diceId; ?>)"><?php echo $die->name; ?></a></li>
                    <?php } ?>
                </ul>
            </li>
        <?php } ?>
        <li>
            <a href="javascript:;">Chat</a>
            <ul class="sub-menu">
                <li><a href="javascript:filterChatMessages(0);">All</a></li>
                <li><a href="javascript:filterChatMessages(1);">User</a></li>
                <li><a href="javascript:filterChatMessages(2);">System</a></li>
            </ul>
        </li>
        <li><a href="javascript:exit();">Exit</a></li>
    </ul>
</div>

<!-- EXIT GAME DIALOG -->
<div id="exit-dialog">

</div>