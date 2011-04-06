<?php echo $this->renderPartial('_newGameDlg', array('decks' => $decks)); ?>

<div id="lobby">
    <div id="lobby-left">
        <div id="lobby-users">
            <?php
            foreach ($chat->users as $user) {
                echo $user->name, '<br />';
            }
            ?>
        </div>
        <div id="lobby-chat">

        </div>
        <div class="clear"></div>
        <div id="lobby-tools">
            <form action="#" method="post">
                <input type="text" id="message" name="message" size="90" />
                <button type="button">Send</button>
            </form>
            <br />
            <?php echo CHtml::link('New Game', '#', array('onclick' => '$("#newgamedlg").dialog("open"); return false;')); ?>
            <?php echo CHtml::link('Join Private', '#', array('onclick' => '$("#newgamedlg").dialog("open"); return false;')); ?>
        </div>
    </div>
    <div id="lobby-right">
        <?php
        foreach ($games as $game) {
            //echo 'a <br />';
        }
        ?>
    </div>
    <div class="clear"></div>
</div>
