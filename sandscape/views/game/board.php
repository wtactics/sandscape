<?php
$last = 0;
if (count($messages)) {
    $last = end($messages);
    $last = $last->messageId;
}

Yii::app()->clientScript->registerCssFile('_resources/css/sandscape/game.common' . (YII_DEBUG ? '' : '.min') . '.css');
Yii::app()->clientScript->registerCssFile('_resources/css/sandscape/game.play' . (YII_DEBUG ? '' : '.min') . '.css');
Yii::app()->clientScript->registerCssFile('_resources/css/sandscape/modal' . (YII_DEBUG ? '' : '.min') . '.css');
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
                        <li class="user-message <?php
                echo ($player1 == $message->userId ? 'player1-text' :
                        ($player2 == $message->userId ? 'player2-text' : 'spectator-text'));
                        ?>">
                            <strong><?php echo date('H:i', strtotime($message->sent)); ?>:</strong>
                            <?php echo $message->message; ?>
                        </li>
                        <?php
                    }
                }
                ?>
            </ul>
        </div>
        <input type="text" id="writemessage" />
    </div>
    <div class="hand"><!-- PLAYER HAND AREA --></div>
</div>
<div class="opponent-area"><!-- OPPONENT GAME AREA --></div>
<div class="play"><!-- PLAYER 1 GAME AREA --></div>

<!-- EXTRA DOM ELEMENTS -->
<?php 

//LOADER DIVS
$this->renderPartial('_loaders');

//IN-GAME MENU
$this->renderPartial('_gamemenu', array('dice' => $dice));

//DIALOG DIVS
$this->renderPartial('_dialogs');