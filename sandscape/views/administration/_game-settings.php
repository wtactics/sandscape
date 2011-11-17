<?php
$js = <<<JS
$('#fixdecknr-help').SetBubblePopupInnerHtml('{$settings['fixdecknr']->description}');
$('#deckspergame-help').SetBubblePopupInnerHtml('{$settings['deckspergame']->description}');
$('#useanydice-help').SetBubblePopupInnerHtml('{$settings['useanydice']->description}');
$('#gamechatspectators-help').SetBubblePopupInnerHtml('{$settings['gamechatspectators']->description}');
JS;

Yii::app()->clientScript->registerScript('bbtxtgs', $js);

echo CHtml::form($this->createURL('administration/savegamesettings'));
?>
<fieldset>
    <legend>Game Options</legend>
    <p>
        <?php
        echo CHtml::checkBox('fixdecknr', $settings['fixdecknr']->value, array('uncheckValue' => $settings['fixdecknr']->value)), '&nbsp;',
        CHtml::label('Fix Deck Number', 'fixdecknr'), '&nbsp;',
        CHtml::image('_resources/images/icon-x16-question-balloon.png', '', array('id' => 'fixdecknr-help', 'class' => 'helpicon'));
        ?>
    </p>
    <p>
        <?php
        echo CHtml::label('Decks per game', 'deckspergame'), '<br />',
        CHtml::textField('deckspergame', $settings['deckspergame']->value, array('class' => 'text')), '&nbsp;',
        CHtml::image('_resources/images/icon-x16-question-balloon.png', '', array('id' => 'deckspergame-help', 'class' => 'helpicon'));
        ?>
    </p>
    <hr />
    <p>
        <?php
        echo CHtml::checkBox('useanydice', $settings['useanydice']->value, array('uncheckValue' => $settings['useanydice']->value)), '&nbsp;',
        CHtml::label('Allow any dice', 'useanydice'), '&nbsp;',
        CHtml::image('_resources/images/icon-x16-question-balloon.png', '', array('id' => 'useanydice-help', 'class' => 'helpicon'));
        ?>
    </p>
    <p>
        <?php
        echo CHtml::label('Spectators can', 'gamechatspectators'), '&nbsp;',
        CHtml::image('_resources/images/icon-x16-question-balloon.png', '', array('id' => 'gamechatspectators-help', 'class' => 'helpicon')),
        '<br />',
        CHtml::dropDownList('gamechatspectators', $settings['gamechatspectators']->value, array(
            0 => 'Be quiet', 1 => 'Speak in chat'
        ));
        ?>
    </p>
</fieldset>
<p>
    <?php echo CHtml::submitButton('Save', array('class' => 'button', 'name' => 'GameSettings')); ?>
</p>
<?php
echo CHtml::endForm();