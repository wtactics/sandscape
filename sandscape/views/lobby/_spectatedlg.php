<div id="spectatedlg">
    <h2>Spectate Game</h2>
    <?php echo CHtml::beginForm($this->createURL('game/spectate'), 'post', array('id' => 'spectateform')); ?>
    <!-- //TODO: show chat settings and other game info. -->
    <p>
        <?php
        echo CHtml::submitButton('Spectate', array(
            'name' => 'SpectateGame',
            'id' => 'btnSpectate'
        ));
        ?>
    </p>
    <?php
    echo CHtml::hiddenField('specgame'),
    CHtml::endForm();
    ?>
</div>
