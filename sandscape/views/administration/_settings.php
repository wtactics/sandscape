<?php
$js = <<<JS
$('#cardscapeurl-help').SetBubblePopupInnerHtml('{$settings['cardscapeurl']->description}');
$('#allowavatar-help').SetBubblePopupInnerHtml('{$settings['allowavatar']->description}');
$('#avatarsize-help').SetBubblePopupInnerHtml('{$settings['avatarsize']->description}');
JS;

Yii::app()->clientScript->registerScript('bbtxtss', $js);

echo CHtml::form($this->createURL('administration/savesandscapesettings'));
?>

<fieldset>
    <legend>Sandscape Configuration</legend>
    <p>
        <?php
        echo CHtml::label('Cardscape URL', 'cardscapeurl'), '&nbsp;',
        CHtml::image('_resources/images/icon-x16-question-balloon.png', '', array('id' => 'cardscapeurl-help', 'class' => 'helpicon')),
        '<br />',
        CHtml::textField('cardscapeurl', $settings['cardscapeurl']->value, array('class' => 'text'));
        ?>
    </p>
    <p>
        <?php
        echo CHtml::checkBox('allowavatar', $settings['allowavatar']->value, array('uncheckValue' => $settings['allowavatar']->value)), '&nbsp;',
        CHtml::label('Allow avatars', 'allowavatar'), '&nbsp;',
        CHtml::image('_resources/images/icon-x16-question-balloon.png', '', array('id' => 'allowavatar-help', 'class' => 'helpicon'));
        ?>
    </p>
    <p>
        <?php
        echo CHtml::label('Avatar size', 'avatarsize'), '&nbsp;',
        CHtml::image('_resources/images/icon-x16-question-balloon.png', '', array('id' => 'avatarsize-help', 'class' => 'helpicon')),
        '<br />',
        CHtml::textField('avatarsize', $settings['avatarsize']->value, array('class' => 'text'));
        ?>
    </p>
</fieldset>
<p>
    <?php echo CHtml::submitButton('Save', array('class' => 'button', 'name' => 'SandscapeSettings')); ?>
</p>
<?php
CHtml::endForm();