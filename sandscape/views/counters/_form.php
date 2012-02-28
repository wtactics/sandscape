<?php $form = $this->beginWidget('CActiveForm', array('id' => 'counter-form')); ?>
<fieldset>
    <legend>Player Counter information</legend>
    <div class="formrow">
        <?php
        echo $form->labelEx($counter, 'name'),
        $form->textField($counter, 'name', array('maxlength' => 150, 'class' => 'text'));
        ?>
    </div>
    <?php echo $form->error($counter, 'name'); ?>

    <div class="formrow">
        <?php
        echo $form->labelEx($counter, 'startValue'),
        $form->textField($counter, 'startValue', array('class' => 'text'));
        ?>
    </div>
    <?php echo $form->error($counter, 'startValue'); ?>

    <div class="formrow">
        <?php
        echo $form->labelEx($counter, 'step'),
        $form->textField($counter, 'step', array('class' => 'text'));
        ?>
    </div>
    <?php echo $form->error($counter, 'step'); ?>

    <div class="formrow">
        <?php echo $form->checkBox($counter, 'available'), '&nbsp;', $form->labelEx($counter, 'available'); ?>
    </div>
    <?php echo $form->error($counter, 'available'); ?>
</fieldset>

<div class="buttonrow">
    <?php
    echo CHtml::submitButton($counter->isNewRecord ? 'Create' : 'Save', array('class' => 'button')),
    CHtml::link('Cancel', $this->createUrl('/counters'));
    ?>
</div>
<?php
$this->endWidget();