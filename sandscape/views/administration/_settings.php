<?php echo CHtml::form($this->createURL('administration/savesettings')); ?>
<fieldset>
    <legend>Game Settings</legend>
    <p>
        <?php
        echo CHtml::checkBox('fixdecknr', $settings['fixdecknr']->value), '&nbsp;',
        CHtml::label('Fix Deck Number', 'fixdecknr'), '&nbsp;',
        CHtml::image('_resources/images/icon-x16-help.png', '', array('id' => 'fixdecknr-help', 'class' => 'helpicon'));
        ?>
    </p>
    <p>
        <?php
        echo CHtml::label('Decks per game', 'deckspergame'), '<br />',
        CHtml::textField('deckspergame', $settings['deckspergame']->value, array('class' => 'text')), '&nbsp;',
        CHtml::image('_resources/images/icon-x16-help.png', '', array('id' => 'deckspergame-help', 'class' => 'helpicon'));
        ?>
    </p>
    <hr />
    <p>
        <?php
        echo CHtml::checkBox('useanydice', $settings['useanydice']->value), '&nbsp;',
        CHtml::label('Disable all dice', 'disabledice'), '&nbsp;',
        CHtml::image('_resources/images/icon-x16-help.png', '', array('id' => 'useanydice-help', 'class' => 'helpicon'));
        ?>
    </p>
    <p>
        <?php
        echo CHtml::label('Spectators can', 'gamechatspectators'), '&nbsp;',
        CHtml::image('_resources/images/icon-x16-help.png', '', array('id' => 'gamechatspectators-help', 'class' => 'helpicon')),
        '<br />',
        CHtml::dropDownList('gamechatspectators', $settings['gamechatspectators']->value, array(
            0 => 'Be quiet', 1 => 'Speak in chat'
        ));
        ?>
    </p>
</fieldset>
<fieldset>
    <legend>Sandscape Configuration</legend>
</fieldset>
<p>
    <?php echo CHtml::submitButton('Save', array('class' => 'button')); ?>
</p>
<?php echo CHtml::hiddenField('Settings', 'Settings'), "\n", CHtml::endForm(); ?>