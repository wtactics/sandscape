<?php
Yii::app()->clientScript->registerCssFile('_resources/css/sandscape/game.common' . (YII_DEBUG ? '' : '.min') . '.css');
Yii::app()->clientScript->registerCssFile('_resources/css/sandscape/game.play' . (YII_DEBUG ? '' : '.min') . '.css');
Yii::app()->clientScript->registerCssFile('_resources/css/sandscape/modal' . (YII_DEBUG ? '' : '.min') . '.css');
//
Yii::app()->clientScript->registerCoreScript('jquery.ui');
//
Yii::app()->clientScript->registerScriptFile('_resources/js/thirdparty/jquery.jgrowl.min.js', CClientScript::POS_HEAD);
Yii::app()->clientScript->registerScriptFile('_resources/js/thirdparty/jquery.simplemodal.1.4.1.min.js', CClientScript::POS_HEAD);
Yii::app()->clientScript->registerScriptFile('_resources/js/sandscape/game.common' . (YII_DEBUG ? '' : '.min') . '.js', CClientScript::POS_HEAD);
Yii::app()->clientScript->registerScriptFile('_resources/js/sandscape/game.play' . (YII_DEBUG ? '' : '.min') . '.js', CClientScript::POS_HEAD);
Yii::app()->clientScript->registerScriptFile('_resources/js/thirdparty/jquery.radialmenu.min.js', CClientScript::POS_HEAD);

$playUrl = $this->createURL('game/play', array('id' => $gameId));
$sendMessageUrl = $this->createUrl('game/sendmessage', array('id' => $gameId));
$updateMessageUrl = $this->createUrl('game/chatupdate', array('id' => $gameId));

$last = 0;
if (count($messages)) {
    $last = end($messages);
    $last = $last->messageId;
}

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