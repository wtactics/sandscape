<div id="exit-dialog">
    <?php echo CHtml::form($this->createUrl('game/leave', array('id' => $gameId))); ?>
    <h2>Exit Game</h2>
    <p>
        //TODO: not implemented yet
    </p>
    <p>
        <?php
        echo CHtml::submitButton('Exit', array(
            'class' => 'simplemodal-close button')), '&nbsp;&nbsp;&nbsp;&nbsp;',
        CHtml::link('Cancel', 'javascript:;', array('class' => 'simplemodal-close'));
        ?>
    </p>
    <?php echo CHtml::endForm(); ?>
</div>