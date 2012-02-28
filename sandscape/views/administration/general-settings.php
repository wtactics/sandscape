<?php
$this->title = 'Sandscape Settings';

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
$('#cardscapeurl-help').SetBubblePopupInnerHtml('{$settings['cardscapeurl']->description}');
$('#allowavatar-help').SetBubblePopupInnerHtml('{$settings['allowavatar']->description}');
$('#avatarsize-help').SetBubblePopupInnerHtml('{$settings['avatarsize']->description}');
JS;

Yii::app()->clientScript->registerScript('bbtxtss', $js);
?>

<h2>Sandscape Settings</h2>

<?php echo CHtml::form($this->createURL('administration/savesandscapesettings')); ?>

<fieldset>
    <legend>Settings</legend>
    <div class="formrow">
        <?php
        echo CHtml::label('Cardscape URL', 'cardscapeurl'),
        CHtml::image('_resources/images/icon-x16-question-balloon.png', '', array('id' => 'cardscapeurl-help', 'class' => 'helpicon')),
        CHtml::textField('cardscapeurl', $settings['cardscapeurl']->value, array('class' => 'text'));
        ?>
    </div>

    <div class="formrow">
        <?php
        echo CHtml::checkBox('allowavatar', $settings['allowavatar']->value, array('uncheckValue' => $settings['allowavatar']->value)), '&nbsp;',
        CHtml::label('Allow avatars', 'allowavatar'),
        CHtml::image('_resources/images/icon-x16-question-balloon.png', '', array('id' => 'allowavatar-help', 'class' => 'helpicon'));
        ?>
    </div>

    <div class="formrow">
        <?php
        echo CHtml::label('Avatar size', 'avatarsize'),
        CHtml::image('_resources/images/icon-x16-question-balloon.png', '', array('id' => 'avatarsize-help', 'class' => 'helpicon')),
        CHtml::textField('avatarsize', $settings['avatarsize']->value, array('class' => 'text'));
        ?>
    </div>

    <div class="formrow">
        <?php
        echo CHtml::label('System E-mail', 'sysemail'),
        CHtml::textField('sysemail', $settings['sysemail']->value, array('class' => 'text'));
        ?>
    </div>
</fieldset>

<div class="buttonrow">
    <?php echo CHtml::submitButton('Save', array('class' => 'button', 'name' => 'SandscapeSettings')); ?>
</div>
<?php
CHtml::endForm();