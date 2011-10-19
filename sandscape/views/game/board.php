<?php
Yii::app()->clientScript->registerScriptFile('_resources/js/game.js', CClientScript::POS_END);

$url = $this->createURL('game/play', array('id' => $gameId));
Yii::app()->clientScript->registerScript('rsqtvar', "var requestUrl = '{$url}';", CClientScript::POS_HEAD);

Yii::app()->clientScript->registerScript('initjs', 'init()');
?>
<div class="opponent">
    <div class="op-graveyard">
        <img src="_cards/default/cardback.reverse.thumb.jpg" />
    </div>
    <div class="op-deck">
        <img src="_cards/default/cardback.reverse.thumb.jpg" />
    </div>
</div>
<div class="player">
    <div class="graveyard">
        <img src="_cards/default/cardback.thumb.jpg"  />
    </div>
    <div class="deck" onclick=";">
        <img src="_cards/default/cardback.thumb.jpg" />
    </div>
</div>