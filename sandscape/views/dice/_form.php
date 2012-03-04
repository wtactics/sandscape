<?php $form = $this->beginWidget('CActiveForm', array('id' => 'dice-form')); ?>
<fieldset>
    <legend>Die information</legend>

    <div class="formrow">
        <?php
        echo $form->labelEx($dice, 'name'),
        $form->textField($dice, 'name', array('size' => 60, 'maxlength' => 150, 'class' => 'text'));
        ?>
    </div>
    <?php echo $form->error($dice, 'name'); ?>

    <div class="formrow">
        <?php
        echo $form->labelEx($dice, 'face'),
        $form->textField($dice, 'face', array('size' => 60, 'maxlength' => 3, 'class' => 'text'));
        ?>
    </div>
    <?php echo $form->error($dice, 'face'); ?>

    <div class="formrow">
        <?php
        echo $form->checkBox($dice, 'enabled'),
        $form->labelEx($dice, 'enabled', array('class' => 'standard'));
        ?>
    </div>
    <?php echo $form->error($dice, 'enabled'); ?>
</fieldset>

<div class="buttonrow">
    <?php
    echo CHtml::submitButton($dice->isNewRecord ? 'Create' : 'Save', array('class' => 'button')),
    CHtml::link('Cancel', $this->createUrl('/dice'));
    ?>
</div>
<?php
$this->endWidget();