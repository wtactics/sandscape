<?php
$this->title = 'Game Options';

Yii::app()->clientScript->registerCssFile('_resources/css/sandscape/forms' . (YII_DEBUG ? '' : '.min') . '.css');
Yii::app()->clientScript->registerCssFile('_resources/css/sandscape/administration' . (YII_DEBUG ? '' : '.min') . '.css');

Yii::app()->clientScript->registerCssFile('_resources/css/thirdparty/jquery.bubblepopup.v2.3.1.css');
Yii::app()->clientScript->registerScriptFile('_resources/js/thirdparty/jquery.bubblepopup.v2.3.1.min.js', CClientScript::POS_HEAD);

$js = <<<JS
$('.helpicon').CreateBubblePopup({
    position: 'right',
    align: 'center',
    tail: {
        align: 'center'
    },
    themeName: 'all-black',
    themePath: '_resources/images/jqBubblePopup',
    alwaysVisible: false,
    closingDelay: 100
});

JS;

Yii::app()->clientScript->registerScript('bublesinit', $js);

$js = <<<JS
$('#fixdecknr-help').SetBubblePopupInnerHtml('{$settings['fixdecknr']->description}');
$('#deckspergame-help').SetBubblePopupInnerHtml('{$settings['deckspergame']->description}');
$('#useanydice-help').SetBubblePopupInnerHtml('{$settings['useanydice']->description}');
$('#gamechatspectators-help').SetBubblePopupInnerHtml('{$settings['gamechatspectators']->description}');
JS;

Yii::app()->clientScript->registerScript('bbtxtgs', $js);
?>

<h2>Game Options</h2>

<?php echo CHtml::form($this->createURL('administration/savegamesettings')); ?>

<fieldset>
    <legend>Options</legend>
    <div class="formrow">
<?php
echo CHtml::checkBox('fixdecknr', $settings['fixdecknr']->value, array('uncheckValue' => $settings['fixdecknr']->value)),
 CHtml::label('Fix Deck Number', 'fixdecknr'), '&nbsp;',
 CHtml::image('_resources/images/icon-x16-question-balloon.png', '', array('id' => 'fixdecknr-help', 'class' => 'helpicon'));
?>
    </div>

    <div class="formrow">
<?php
echo CHtml::label('Decks per game', 'deckspergame'),
 CHtml::textField('deckspergame', $settings['deckspergame']->value, array('class' => 'text')), '&nbsp;',
 CHtml::image('_resources/images/icon-x16-question-balloon.png', '', array('id' => 'deckspergame-help', 'class' => 'helpicon'));
?>
    </div>

    <div class="formrow">
<?php
echo CHtml::checkBox('useanydice', $settings['useanydice']->value, array('uncheckValue' => $settings['useanydice']->value)),
 CHtml::label('Allow any dice', 'useanydice'),
 CHtml::image('_resources/images/icon-x16-question-balloon.png', '', array('id' => 'useanydice-help', 'class' => 'helpicon'));
?>
    </div>

    <div class="formrow">
<?php
echo CHtml::label('Spectators can', 'gamechatspectators'),
 CHtml::image('_resources/images/icon-x16-question-balloon.png', '', array('id' => 'gamechatspectators-help', 'class' => 'helpicon')),
 '<br />',
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