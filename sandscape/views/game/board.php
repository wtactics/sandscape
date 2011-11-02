<?php
$last = 0;
if (count($messages)) {
    $last = end($messages);
    $last = $last->messageId;
}

Yii::app()->clientScript->registerCoreScript('jquery');
Yii::app()->clientScript->registerCoreScript('jquery.ui');
Yii::app()->clientScript->registerScriptFile('_resources/js/jquery.bubblepopup.v2.3.1.min.js', CClientScript::POS_HEAD);
Yii::app()->clientScript->registerScriptFile('_resources/js/jquery.jgrowl.minimized.js', CClientScript::POS_HEAD);
Yii::app()->clientScript->registerScriptFile('_resources/js/jquery.simplemodal.1.4.1.min.js', CClientScript::POS_HEAD);
Yii::app()->clientScript->registerScriptFile('_resources/js/game.js', CClientScript::POS_HEAD);

$url = $this->createURL('game/play', array('id' => $gameId));
$url2 = $this->createUrl('game/gamechatupdate', array('id' => $gameId));

$startJS = <<<JS
    lastReceived = {$last};
    initTable('{$url}', '{$url2}');
    updateMessageScroll();

    $('#file-menu').click(function (e) {
        $('#file-menu-items').slideToggle('medium');
    });
JS;
Yii::app()->clientScript->registerScript('startjs', $startJS);

$this->title = 'Playing';
?>

<div id="info-widget">
    <img id="file-menu" src="_resources/images/icon-x32-menu.png" />
    <ul id="file-menu-items">
        <li>
            <a href="javascript:;">Chat &Gt;</a>
            <ul class="sub-menu">
                <li><a href="#">Show all</a></li>
                <li><a href="#">Show system</a></li>
                <li><a href="#">Show user messages</a></li>
            </ul>
        </li>
        <?php if (count($dice)) { ?>
            <li>
                <a href="javascript:;">Roll Dice &Gt;</a>
                <ul class="sub-menu">
                    <?php foreach ($dice as $die) { ?>
                        <li>
                            <a href="javascript:roll(<?php echo $die->diceId; ?>);">
                                <?php echo $die->name, '&nbsp;(', $die->face, ')'; ?>
                            </a>
                        </li>
                    <?php } ?>
                </ul>
            </li>
        <?php } ?>
        <li><a href="javascript:;">Game &Gt;</a>
            <ul class="sub-menu">
                <li><a href="#">Lost</a></li>
                <li><a href="#">Pause</a></li>
            </ul>
        </li>
        <li><a href="<?php echo $this->createURL('game/leave', array('id' => $gameId)); ?>">Exit</a></li>
    </ul>
    <div id="card-info">
        <!-- Find the pixel size for 70% height -->
        <img src="_game/cards/18e9b964776bbe6c9f6842f1feba8b8b.jpg" height="70%" />
    </div>
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
    <div class="hand"><!-- PLAYER HAND AREA --></div>
    <div class="play"><!-- PLAYER CENTER AREA, CARD AREA --></div>

    <!-- <img id="deck-nob" src="_cards/up/thumbs/cardback.jpg" /> -->
    <div id="deck-widget">
        <div id="deck-slide"><!-- DECK CONTAINER --></div>
    </div>                   
</div>

<!-- LOADER DIVS -->
<div id="opponent-loader" class="loader" style="display:none;"">
     <img id="img-loader" src="_resources/images/game-loader.gif" />
    <br />
    <span>Waiting for opponent.</span>
</div>

<div id="game-loader" class="loader" style="display:none;"">
     <img id="img-loader" src="_resources/images/game-loader.gif" />
    <br />
    <span>Building game.</span>
</div>