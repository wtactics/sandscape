<?php Yii::app()->clientScript->registerCssFile('_resources/css/sandscape/administration.css'); ?>
<div class="tools-row even">
    <?php echo CHtml::form($this->createURL('administration/prunechats')); ?>
    <h3>Remove old chat messages</h3>
    <p>
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
        <br /><br />
        <?php echo CHtml::checkBox('gamemessages'), '&nbsp;', CHtml::label('Including game messages?', 'gamemessages'); ?>
    </p>
    <span>
        <?php echo CHtml::submitButton('Execute', array('class' => 'button')); ?>
    </span>
    <div style="clear: both;"></div>
    <?php echo CHtml::endForm(); ?>
</div>

<div class="tools-row">
    <?php echo CHtml::form($this->createURL('administration/removeorphan')); ?>
    <h3>Remove orphan card images</h3>
    <p>
        Remove all card images that are not used any more.
    </p>
    <span>
        <?php echo CHtml::submitButton('Execute', array('class' => 'button')); ?>
    </span>
    <div style="clear: both;"></div>
    <?php echo CHtml::endForm(); ?>
</div>
