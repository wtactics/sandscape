<?php
$this->title = 'Sandscape Settings';

Yii::app()->clientScript->registerCssFile('_resources/css/sandscape/forms' . (YII_DEBUG ? '' : '.min') . '.css');
?>

<h2>Sandscape Settings</h2>

<?php echo CHtml::form($this->createURL('administration/sandscapesettings')); ?>

<fieldset>
    <legend>Settings</legend>
    <div class="formrow">
        <?php
        echo CHtml::label('System E-mail', 'sysemail'),
        CHtml::textField('sysemail', $settings['sysemail']->value, array('class' => 'large'));
        ?>
    </div>

    <div class="formrow">
        <?php
        echo CHtml::label('Cardscape URL', 'cardscapeurl'),
        CHtml::textField('cardscapeurl', $settings['cardscapeurl']->value, array('class' => 'large'));
        ?>
    </div>  

    <div class="formrow">
        <?php
        echo CHtml::label('Avatar size (WxH)', 'avatarsize'),
        CHtml::textField('avatarsize', $settings['avatarsize']->value, array('class' => 'standard'));
        ?>
    </div>

    <div class="formrow">
        <?php
        echo CHtml::label('Allow avatar upload', 'allowavatar'),
        CHtml::checkBox('allowavatar', $settings['allowavatar']->value, array('uncheckValue' => 0));
        ?>
    </div>
</fieldset>

<div class="buttonrow">
    <?php echo CHtml::submitButton('Save', array('class' => 'button', 'name' => 'SandscapeSettings')); ?>
</div>
<?php
CHtml::endForm();