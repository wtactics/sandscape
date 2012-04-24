<div id="exit-dlg">
    <?php echo CHtml::form($this->createUrl('game/leave', array('id' => $gameId))); ?>
    <h2>Exit Game</h2>
    <div>
    </div>
    <div>
        <?php
        echo CHtml::submitButton('Exit', array(
            'class' => 'simplemodal-close button')),
        CHtml::link('Cancel', 'javascript:;', array('class' => 'simplemodal-close'));
        ?>
    </div>
    <?php echo CHtml::endForm(); ?>
</div>