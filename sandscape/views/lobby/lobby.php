<?php
$url = $this->createURL('game/chatupdate');

$last = 0;
if (count($messages)) {
    $last = end($messages);
    $last = $last->messageId;
}

Yii::app()->clientScript->registerCssFile('_resources/css/sandscape/lobby.css');
Yii::app()->clientScript->registerCssFile('_resources/css/sandscape/modal.css');
Yii::app()->clientScript->registerScriptFile('_resources/js/sandscape/lobby.js');
Yii::app()->clientScript->registerScriptFile('_resources/js/thirdparty/jquery.simplemodal.1.4.1.min.js');

Yii::app()->clientScript->registerScript('msgsjs', "lastReceived = {$last};\ninitLobby('{$url}');\nupdateMessageScroll();");

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
            if (in_array(Yii::app()->user->id, array($game->player1, $game->player2)) && !$game->ended) {
                ?>
                <li class="success">
                    <span>
                        <a href="<?php echo $this->createURL('game/play', array('id' => $game->gameId)); ?>">Return to Game</a>
                        &nbsp;-&nbsp;
                        <?php echo Yii::app()->dateFormatter->formatDateTime(strtotime($game->created), 'short', false); ?>
                    </span>
                    <br />
                    <?php if ($game->player2) { ?>
                        <span>Opponent: <?php echo (Yii::app()->user->id == $game->player1 ? $game->player20->name : $game->player10->name); ?></span>
                    <?php } else { ?>
                        <span>No opponent yet.</span>
                    <?php } ?>
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
                <li class="<?php echo $class; ?>">
                    <input type="hidden" class="hGameId" value="<?php echo $game->gameId; ?>" name="gameId-<?php echo $game->gameId; ?>" />
                    <input type="hidden" class="hGameDM" value="<?php echo $game->maxDecks; ?>" name="gameDM-<?php echo $game->gameId; ?>" />
                    <span><?php echo date(DATE_W3C, strtotime($game->created)); ?></span>
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
    <button type="button" class="button" onclick="sendMessage('<?php echo $this->createURL('game/sendmessage'); ?>');" id="sendbtn">Send</button>
</div>
<div class="span-4 last">
    <a href="javascript:;" onclick="$('#createdlg').modal();" class="button">Create Game</a>
</div>

<div style="display: none">
    <?php
    $this->renderPartial('_createdlg', array(
        'decks' => $decks,
        'fixDeckNr' => $fixDeckNr,
        'decksPerGame' => $decksPerGame
    ));

    $this->renderPartial('_joindlg', array(
        'decks' => $decks
    ));

    $this->renderPartial('_spectatedlg');
    ?>
</div>