<?php
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/libraries/jquery-jgrowl-min.js', CClientScript::POS_HEAD);
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/libraries/jquery-radialmenu-min.js', CClientScript::POS_HEAD);

if (YII_DEBUG) {
    Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/css/game.common.css');
    Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/css/game.play.css');

    Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/game.common.js', CClientScript::POS_HEAD);
    Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/game.play.js', CClientScript::POS_HEAD);
}

$playUrl = $this->createURL('game/play', array('id' => $gameId));
$sendMessageUrl = $this->createUrl('game/sendmessage', array('id' => $gameId));
$updateMessageUrl = $this->createUrl('game/chatupdate', array('id' => $gameId));

$last = 0;
if (count($messages)) {
    $last = end($messages);
    $last = $last->messageId;
}

//TODO: full URL in a better place
$url = Yii::app()->baseUrl;

$startJS = <<<JS
globals.chat.sendUrl = '{$sendMessageUrl}';
globals.chat.updateUrl = '{$updateMessageUrl}';
globals.chat.lastReceived = {$last};
globals.game.url = '{$playUrl}';
globals.user.id = {$user->id};
globals.user.name = '{$user->name}';
globals.url = '{$url}';    
init();

JS;
Yii::app()->clientScript->registerScript('startjs', $startJS);

$this->title = 'Playing';
?>

<div class="opponent-area"><!-- OPPONENT GAME AREA --></div>
<div class="play"><!-- PLAYER 1 GAME AREA --></div>
<div id="message-div">
    <input type="text" name="message" id="message" />
</div>

<!-- EXTRA DOM ELEMENTS -->
<?php
//LOADER DIVS
$this->renderPartial('_loaders');

//IN-GAME MENUS
$this->renderPartial('_leftmenu', array('messages' => $messages));

$this->renderPartial('_gamemenu', array('dice' => $dice));

$this->renderPartial('_hand');

//DIALOG DIVS
$this->renderPartial('_dialogs', array('gameId' => $gameId));