<?php
$url = $this->createURL('game/lobbychatupdate');

$last = 0;
if (count($messages)) {
    $last = end($messages);
    $last = $last->messageId;
}

Yii::app()->clientScript->registerCssFile('_resources/css/lobby.css');
Yii::app()->clientScript->registerCssFile('_resources/css/modal.css');
Yii::app()->clientScript->registerScriptFile('_resources/js/lobby.js');
Yii::app()->clientScript->registerScriptFile('_resources/js/jquery.simplemodal.1.4.1.min.js');

Yii::app()->clientScript->registerScript('msgsjs', "lastReceived = {$last}; initLobby('{$url}');updateMessageScroll();");

$this->title = 'Sandscape Lobby';
?>

<h2>Lobby</h2>
<div class="span-3">
    <h3>Users</h3>
    <ul id="userlist">
        <?php foreach ($users as $user) { ?>
            <li>
                <a href="<?php echo $this->createURL((Yii::app()->user->id != $user->userId ? 'user/view' : 'user/profile'), array('id' => $user->userId)); ?>">
                    <?php echo $user->name; ?>
                </a>
            </li>
        <?php } ?>
    </ul>
</div>
<div class="span-13 border">
    <h3>Chat</h3>
    <ul id="lobbychat">
        <?php foreach ($messages as $message) { ?>
            <li>
                <span>
                    <strong><?php echo $message->user->name; ?></strong>
                    [<?php echo Yii::app()->dateFormatter->formatDateTime(strtotime($message->sent), 'short'); ?>]:
                </span>
                <br />
                <?php echo CHtml::encode($message->message); ?>
            </li>
        <?php } ?>
    </ul>
</div>
<div class="span-6 last">
    <h3>Games</h3>
    <ul id="gamelist">
        <?php
        foreach ($games as $game) {
            if (in_array(Yii::app()->user->id, array($game->player1, $game->player2)) && $game->running) {
                ?>
                <li class="success">
                    <span>
                        <a href="<?php echo $this->createURL('game/play', array('id' => $game->gameId)); ?>">Return to Game</a>
                        &nbsp;-&nbsp;
                        <?php echo Yii::app()->dateFormatter->formatDateTime(strtotime($game->created), 'short', false); ?>
                    </span>
                    <br />
                    <span>Opponent: <?php echo (Yii::app()->user->id == $game->player1 ? $game->player20->name : $game->player10->name); ?></span>
                </li>
                <?php
            } else {
                $class = 'error';
                if ($game->running) {
                    $class = 'success spectate';
                } else if (!$game->player2) {
                    $class = 'info join';
                }
                ?>
                <li class="<?php echo $class; ?>" id="game-<?php echo $game->gameId; ?>">
                    <span><?php echo Yii::app()->dateFormatter->formatDateTime(strtotime($game->created), 'short', false); ?></span>
                    <br />
                    <?php if ($game->running) { ?>
                        <span><?php echo $game->player10->name, '&nbsp;-&nbsp;', $game->player20->name; ?></span>
                    <?php } else { ?>
                        <span>Create by <?php echo $game->player10->name; ?></span>
                    <?php } ?>
                </li>
                <?php
            }
        }
        ?>
    </ul>
</div>
<hr />
<div class="span-18 centered">
    <input type="text" class="text" id="writemessage" />
    <button type="button" onclick="sendMessage('<?php echo $this->createURL('game/sendlobbymessage'); ?>');" id="sendbtn">Send</button>
</div>
<div class="span-4 last">
    <a href="javascript:;" onclick="$('#createdlg').modal();">Create</a>
    &nbsp;:&nbsp;
    <a href="javascript:;" onclick="alert('Private games are not not implemented yet!');//$('#joinprivatedlg').modal();">Private Game</a>
</div>

<div style="display: none">
    <?php
    $this->renderPartial('_createdlg', array('decks' => $decks));
    $this->renderPartial('_joindlg', array('decks' => $decks));
    $this->renderPartial('_joinprivatedlg', array('decks' => $decks));
    ?>
</div>