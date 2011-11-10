<?php
$last = 0;
if (count($messages)) {
    $last = end($messages);
    $last = $last->messageId;
}
//Yii::app()->clientScript->registerCoreScript('jquery.ui');
//Yii::app()->clientScript->registerScriptFile('_resources/js/jquery.bubblepopup.v2.3.1.min.js', CClientScript::POS_HEAD);
//Yii::app()->clientScript->registerScriptFile('_resources/js/jquery.jgrowl.minimized.js', CClientScript::POS_HEAD);
//Yii::app()->clientScript->registerScriptFile('_resources/js/jquery.simplemodal.1.4.1.min.js', CClientScript::POS_HEAD);
//Yii::app()->clientScript->registerScriptFile('_resources/js/game.js', CClientScript::POS_HEAD);
//Yii::app()->clientScript->registerScriptFile('_resources/js/jquery.radialmenu.min.js', CClientScript::POS_HEAD);

$watchUrl = $this->createUrl('game/spectate', array('id' => $gameId));
$sendMessageUrl = $this->createUrl('game/sendgamemessage', array('id' => $gameId));
$updateMessageUrl = $this->createUrl('game/gamechatupdate', array('id' => $gameId));

$startJS = <<<JS
globals.chat.sendUrl = '{$sendMessageUrl}';
globals.chat.updateUrl = '{$updateMessageUrl}';
globals.chat.lastReceived = {$last};
globals.game.url = '{$watchUrl}';
    
init();
updateMessageScroll();

JS;
Yii::app()->clientScript->registerScript('startjs', $startJS);

$this->title = 'Playing';
?>

<div id="left-column">
    <img id="card-info" src="_game/cards/18e9b964776bbe6c9f6842f1feba8b8b.jpg" />
    <div id="chat">
        <ul id="chat-messages">
            <?php foreach ($messages as $message) { ?>
                <li class="user-message">
                    <strong><?php echo $message->user->name; ?></strong>: <?php echo $message->message; ?>
                </li>
            <?php } ?>
        </ul>
        <input type="text" id="writemessage" />
    </div>
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
     <img id="img-loader" src="_resources/images/game-loader-2.gif" />
    <br />
    <span>Waiting for opponent.</span>
</div>

<div id="game-loader" class="loader" style="display:none;">
     <img id="img-loader" src="_resources/images/game-loader-2.gif" />
    <br />
    <span>Building game.</span>
</div>