<?php $form = $this->beginWidget('CActiveForm', array('id' => 'counter-form')); ?>
<fieldset>
    <legend>Player Counter information</legend>
    <p>
        <?php
        echo $form->labelEx($counter, 'name'), '<br />',
        $form->textField($counter, 'name', array('maxlength' => 150, 'class' => 'text'));
        ?>
    </p>
    <?php echo $form->error($counter, 'name'); ?>
    <p>
        <?php
        echo $form->labelEx($counter, 'startValue'), '<br />',
        $form->textField($counter, 'startValue', array('class' => 'text'));
        ?>
    </p>
    <?php echo $form->error($counter, 'startValue'); ?>
    <p>
        <?php
        echo $form->labelEx($counter, 'step'), '<br />',
        $form->textField($counter, 'step', array('class' => 'text'));
        ?>
    </p>
    <?php echo $form->error($counter, 'step'); ?>
    <p>
        <?php echo $form->checkBox($counter, 'available'), '&nbsp;', $form->labelEx($counter, 'available'); ?>
    </p>
    <?php echo $form->error($counter, 'available');
    ?>
</fieldset>
<p>
    <?php echo CHtml::submitButton($counter->isNewRecord ? 'Create' : 'Save', array('class' => 'button')); ?>
</p>
<?php
$this->endWidget();