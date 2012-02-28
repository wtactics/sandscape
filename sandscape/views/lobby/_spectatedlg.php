<div id="spectatedlg">
    <?php echo CHtml::beginForm($this->createURL('game/spectate'), 'post', array('id' => 'spectateform')); ?>
    <h2>Spectate Game</h2>
    <div class="lobby-dlg-only info">
        <p>
            You can spectate this game but you may not be able to use the game chat to send messages since the 
            game creator may have disabled it.
        </p>
        <?php echo CHtml::hiddenField('specgame'); ?>
    </div>
    <p>
        <?php
        echo CHtml::submitButton('Spectate', array(
            'name' => 'SpectateGame',
            'id' => 'btnSpectate',
            'class' => 'button'
        )),
        CHtml::link('Cancel', 'javascript:;', array('class' => 'simplemodal-close'));
        ?>
    </p>
    <?php CHtml::endForm(); ?>
</div>
