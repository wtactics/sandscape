<?php
Yii::app()->clientScript->registerCssFile('_resources/css/sandscape/administration' . (YII_DEBUG ? '' : '.min') . '.css');

$this->title = 'Maintenace Tools';
?>

<h2>Maintenance Tools</h2>

<div class="tools-row even">
    <?php echo CHtml::form($this->createURL('administration/prunechats')); ?>
    <h3>Remove old chat messages</h3>
    <div class="formrow">
        <?php echo CHtml::label('Messages older than', 'dates'), '<br />'; ?>
        <?php
        $this->widget('zii.widgets.jui.CJuiDatePicker', array(
            'name' => 'date',
            'options' => array(
                'showAnim' => 'fold',
                'dateFormat' => 'yy-mm-dd'
            ),
            'htmlOptions' => array(
                'style' => 'height:20px;'
            ),
        ));
        ?>
        <?php echo CHtml::checkBox('gamemessages'), '&nbsp;', CHtml::label('Including game messages?', 'gamemessages'); ?>
    </div>
    <span>
        <?php echo CHtml::submitButton('Execute', array('class' => 'button')); ?>
    </span>

    <div style="clear: both;"></div>
    <?php echo CHtml::endForm(); ?>
</div>

<div class="tools-row">
    <?php echo CHtml::form($this->createURL('administration/removeorphan')); ?>
    <h3>Remove orphan card images</h3>
    <div class="formrow">
        Remove all card images that are not used any more.
    </div>
    <span>
        <?php echo CHtml::submitButton('Execute', array('class' => 'button')); ?>
    </span>

    <div style="clear: both;"></div>
    <?php echo CHtml::endForm(); ?>
</div>
