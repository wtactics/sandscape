<div id="exit-dlg">
    <?php echo CHtml::form($this->createUrl('game/leave', array('id' => $gameId))); ?>
    <h2>Exit Game</h2>
    <div>
        //TODO: not implemented yet
        
        Pause game?
        End Game?
        Victory to:
        
        Both players need to agree on the outcome, if not, the game is considered to be running.
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