<?php $form = $this->beginWidget('CActiveForm', array('id' => 'dice-form')); ?>
<fieldset>
    <legend>Dice information</legend>
    <p>
        <?php
        echo $form->labelEx($dice, 'name'), '<br />',
        $form->textField($dice, 'name', array('size' => 60, 'maxlength' => 150, 'class' => 'text'));
        ?>
    </p>
    <?php echo $form->error($dice, 'name'); ?>
    <p>
        <?php
        echo $form->labelEx($dice, 'face'), '<br />',
        $form->textField($dice, 'face', array('size' => 60, 'maxlength' => 3, 'class' => 'text'));
        ?>
    </p>
    <?php echo $form->error($dice, 'face'); ?>
    <p>
        <?php echo $form->checkBox($dice, 'selected'), '&nbsp;', $form->labelEx($dice, 'selected'); ?>
    </p>
    <?php echo $form->error($dice, 'selected');
    ?>
</fieldset>
<p>
    <?php echo CHtml::submitButton($dice->isNewRecord ? 'Create' : 'Save', array('class' => 'button')); ?>
</p>
<?php $this->endWidget(); ?>