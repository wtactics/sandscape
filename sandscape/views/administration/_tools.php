<?php Yii::app()->clientScript->registerCssFile('_resources/css/administration.css'); ?>
<div class="tools-row even">
    <?php echo CHtml::form('#'); ?>
    <h3>Remove old chat messages</h3>
    <p>
        <?php
        echo CHtml::label('Messages older than', 'dates'), '<br />',
        CHtml::textField('dates', null, array('class' => 'text'));
        ?>
        <br />
        <?php echo CHtml::checkBox('gamemessages'), CHtml::label('Remove game messages?', 'gamemessages'); ?>
        <br />
        <?php
        echo Chtml::radioButtonList('filtermessages', null, array(
            0 => 'All messages',
            1 => 'User messages',
            2 => 'System messages'
                ), array('class' => 'margined'));
        ?>
    </p>
    <span>
        <?php echo CHtml::submitButton('Execute', array('class' => 'button')); ?>
    </span>
    <div style="clear: both;"></div>
    <?php echo CHtml::endForm(); ?>
</div>

<div class="tools-row">
    <?php echo CHtml::form('#'); ?>
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
