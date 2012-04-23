<?php
Yii::app()->clientScript->registerCssFile('_resources/css/sandscape/forms' . (YII_DEBUG ? '' : '.min') . '.css');

$this->title = 'Maintenace Tools';
?>

<h2>Maintenance Tools</h2>

<?php echo CHtml::form($this->createURL('administration/prunechats')); ?>
<div class="formrow">
    <?php
    echo CHtml::label('Remove messages before', 'dates');

    $this->widget('zii.widgets.jui.CJuiDatePicker', array(
        'name' => 'date',
        'options' => array(
            'showAnim' => 'fold',
            'dateFormat' => 'yy-mm-dd'
        )
    ));
    ?>
</div>

<div class="formrow">
    <?php echo CHtml::label('Include game messages', 'gamemessages'), CHtml::checkBox('gamemessages'); ?>
</div>

<div class="buttonrow">
    <?php echo CHtml::submitButton('Execute', array('class' => 'button')); ?>
</div>

<?php
echo CHtml::endForm(),
 CHtml::form($this->createURL('administration/removeorphan'));
?>

<div class="formrow">
    Remove all card images that are not used any more.
</div>

<div class="buttonrow">
    <?php echo CHtml::submitButton('Execute', array('class' => 'button')); ?>
</div>

<?php
echo CHtml::endForm();
