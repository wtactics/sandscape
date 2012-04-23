<?php
$this->title = 'Game Options';

Yii::app()->clientScript->registerCssFile('_resources/css/sandscape/forms' . (YII_DEBUG ? '' : '.min') . '.css');
Yii::app()->clientScript->registerCssFile('_resources/css/sandscape/administration' . (YII_DEBUG ? '' : '.min') . '.css');

?>

<h2>Game Options</h2>

<?php echo CHtml::form($this->createURL('administration/gameoptions')); ?>

<fieldset>
    <legend>Options</legend>
    <div class="formrow">
        <?php
        echo CHtml::label('Fix Deck Number', 'fixdecknr'),
        CHtml::checkBox('fixdecknr', $settings['fixdecknr']->value, array('uncheckValue' => 0));
        ?>
    </div>

    <div class="formrow">
        <?php
        echo CHtml::label('Decks per game', 'deckspergame'),
        CHtml::textField('deckspergame', $settings['deckspergame']->value, array('class' => 'numeric'));
        ?>
    </div>

    <div class="formrow">
        <?php
        echo CHtml::label('Allow any dice', 'useanydice'),
        CHtml::checkBox('useanydice', $settings['useanydice']->value, array('uncheckValue' => 0));
        ?>
    </div>

    <div class="formrow">
        <?php
        echo CHtml::label('Spectators can', 'gamechatspectators'),
        CHtml::dropDownList('gamechatspectators', $settings['gamechatspectators']->value, array(
            0 => 'Be quiet', 1 => 'Speak in chat'
        ));
        ?>
    </div>
</fieldset>

<div class="buttonrow">
    <?php echo CHtml::submitButton('Save', array('class' => 'button', 'name' => 'GameSettings')); ?>
</div>
<?php
echo CHtml::endForm();