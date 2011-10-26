<?php
//$last = 0;
//if (count($messages)) {
//    $last = end($messages);
//    $last = $last->messageId;
//}

//Yii::app()->clientScript->registerCoreScript('jquery');
//Yii::app()->clientScript->registerCoreScript('jquery.ui');
//Yii::app()->clientScript->registerScriptFile('_resources/js/jquery.bubblepopup.v2.3.1.min.js', CClientScript::POS_HEAD);
//Yii::app()->clientScript->registerScriptFile('_resources/js/jquery.jgrowl.minimized.js', CClientScript::POS_HEAD);
//Yii::app()->clientScript->registerScriptFile('_resources/js/jquery.simplemodal.1.4.1.min.js', CClientScript::POS_HEAD);
//Yii::app()->clientScript->registerScriptFile('_resources/js/game.js', CClientScript::POS_HEAD);

//$url = $this->createURL('game/play', array('id' => $gameId));
//$url2 = $this->createUrl('game/gamechatupdate', array('id' => $gameId));
//Yii::app()->clientScript->registerScript('startjs', "lastReceived = {$last};initTable('{$url}', '{$url2}');updateMessageScroll();");

$this->title = 'Watching a Game';
?>

<div id="chat" style="z-index: 999">
    <ul id="chat-messages">
        <?php //foreach ($messages as $message) { ?>
            <li class="user-message"><span><strong><?php //echo $message->user->name; ?></strong>
                    [<?php //echo Yii::app()->dateFormatter->formatDateTime(strtotime($message->sent), 'short'); ?>]:</span>
                <?php //echo $message->message; ?>
            </li>
        <?php //} ?>
    </ul>
    <div id="controls">
        <p>
            <input type="text" class="text" id="writemessage" />
            <button type="button" onclick="sendMessage('<?php //echo $this->createURL('game/sendgamemessage', array('id' => $gameId)); ?>');" id="sendbtn">Send</button>
        </p>
        <div id="filters">
            Filter:
            <input type="radio" name="filter" id="fshow-all" onchange="filterChatMessages(this);" checked="checked" /> All ::
            <input type="radio" name="filter" id="fshow-user"onchange="filterChatMessages(this);" /> User ::
            <input type="radio" name="filter" id="fshow-system" onchange="filterChatMessages(this);" /> System         
        </div>
    </div>
</div>
<div class="player-top"><!-- PLAYER 2 --></div>
<div id="player-bottom"><!-- PLAYER 2 --></div>

<!-- LOADER DIVS -->
<div id="opponent-loader" class="loader" style="display:none;"">
     <img id="img-loader" src="_resources/images/loader2.gif" />
    <br />
    <span>Waiting for opponent.</span>
</div>

<div id="game-loader" class="loader" style="display:none;"">
     <img id="img-loader" src="_resources/images/loader2.gif" />
    <br />
    <span>Building game.</span>
</div>