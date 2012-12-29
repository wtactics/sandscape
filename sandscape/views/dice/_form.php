<?php $form = $this->beginWidget('CActiveForm', array('id' => 'dice-form')); ?>
<fieldset>
    <legend>Die information</legend>

    <div class="formrow">
        <?php
        echo $form->labelEx($dice, 'name'),
        $form->textField($dice, 'name', array('size' => 60, 'maxlength' => 150, 'class' => 'large'));
        ?>
    </div>
    <?php echo $form->error($dice, 'name'); ?>

    <div class="formrow">
        <?php
        echo $form->labelEx($dice, 'face'),
        $form->textField($dice, 'face', array('size' => 60, 'maxlength' => 3, 'class' => 'numeric'));
        ?>
    </div>
    <?php echo $form->error($dice, 'face'); ?>

    <div class="formrow">
        <?php
        echo $form->labelEx($dice, 'enabled'), $form->checkBox($dice, 'enabled');
        ?>
    </div>
    <?php echo $form->error($dice, 'enabled'); ?>
</fieldset>

<div class="buttonrow">
    <?php
    echo CHtml::submitButton('Save', array('class' => 'button')),
    CHtml::link('Cancel', $this->createUrl('dice/index'));
    ?>
</div>
<?php
$this->endWidget();