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
Yii::app()->clientScript->registerScript('startjs', "lastReceived = {$last};initTable('{$url}', '{$url2}');updateMessageScroll();");

$this->title = 'Playing';
?>

<div id="info-widget">
    <?php
    $this->widget('CTabView', array(
        'tabs' => array(
            'tab0' => array(
                'title' => 'Chat',
                'view' => '_chat',
                'data' => array('messages' => $messages, 'gameId' => $gameId)
            ),
            'tab1' => array(
                'title' => 'Card',
                'view' => '_card-info',
            ),
            'tab2' => array(
                'title' => 'Actions',
                'view' => '_gameactions'
            ),
            'tab3' => array(
                'title' => 'Tools',
                'view' => '_tools',
                'data' => array()
            )
        ),
        'cssFile' => '_resources/css/game-tabs.css'
    ));
    ?>
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
     <img id="img-loader" src="_resources/images/loader2.gif" />
    <br />
    <span>Waiting for opponent.</span>
</div>

<div id="game-loader" class="loader" style="display:none;"">
     <img id="img-loader" src="_resources/images/loader2.gif" />
    <br />
    <span>Building game.</span>
</div>