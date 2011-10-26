<?php
echo CHtml::form('#');

$settings = (object) array('fixDeckNr' => 0, 'decksPerGame' => 0, 'useAnyDice' => 0);
?>
<fieldset>
    <legend>Game Settings</legend>
    <p>
        <?php
        echo CHtml::checkBox('fixdecknr', $settings->fixDeckNr), '&nbsp;',
        CHtml::label('Fix Deck Number', 'fixdecknr'), '&nbsp;',
        CHtml::image('_resources/images/icons/x16/help.png', '', array('id' => 'fixdecknr-help'));
        ?>
    </p>
    <p>
        <?php
        echo CHtml::label('Decks per game', 'deckspergame'), '<br />',
        CHtml::textField('deckspergame', $settings->decksPerGame, array('class' => 'text')), '&nbsp;',
        CHtml::image('_resources/images/icons/x16/help.png', '', array('id' => 'deckspergame-help'));
        ?>
    </p>
    <hr />
    <p>
        <?php
        echo CHtml::checkBox('disabledice', $settings->useAnyDice), '&nbsp;',
        CHtml::label('Disable all dice', 'disabledice'), '&nbsp;',
        CHtml::image('_resources/images/icons/x16/help.png', '', array('id' => 'disabledice-help'));
        ?>
    </p>
</fieldset>
<fieldset>
    <legend>Sandscape Configuration</legend>
</fieldset>
<p>
<?php echo CHtml::submitButton('Save', array('class' => 'button')); ?>
</p>
<?php echo CHtml::endForm(); ?>