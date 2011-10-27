<div id="chat">
    <ul id="chat-messages">
        <?php foreach ($messages as $message) { ?>
            <li class="user-message"><span><strong><?php echo $message->user->name; ?></strong>
                    [<?php echo Yii::app()->dateFormatter->formatDateTime(strtotime($message->sent), 'short'); ?>]:</span>
                <?php echo $message->message; ?>
            </li>
        <?php } ?>
    </ul>
    <div id="controls">
        <p>
            <input type="text" class="text" id="writemessage" />
            <button type="button" onclick="sendMessage('<?php echo $this->createURL('game/sendgamemessage', array('id' => $gameId)); ?>');" id="sendbtn">Send</button>
        </p>
        <div id="filters">
            Filter:
            <input type="radio" name="filter" id="fshow-all" onchange="filterChatMessages(this);" checked="checked" /> All ::
            <input type="radio" name="filter" id="fshow-user"onchange="filterChatMessages(this);" /> User ::
            <input type="radio" name="filter" id="fshow-system" onchange="filterChatMessages(this);" /> System         
        </div>
    </div>
</div>F