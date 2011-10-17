<?php
$form = $this->beginWidget('CActiveForm', array(
    'id' => 'user-form',
    'enableAjaxValidation' => false,
        ));
?>

<?php //echo $form->errorSummary($model); ?>

<p>
    <?php echo $form->labelEx($model, 'name'); ?>
    <?php echo $form->textField($model, 'name', array('size' => 60, 'maxlength' => 100)); ?>

</p>
<?php //echo $form->error($model, 'name'); ?>

<p>
    <?php echo $form->labelEx($model, 'email'); ?>
    <?php echo $form->textField($model, 'email', array('size' => 60, 'maxlength' => 255)); ?>

</p>
<?php //echo $form->error($model, 'email'); ?>

<p>
    <?php echo $form->labelEx($model, 'admin'); ?>
    <?php echo $form->textField($model, 'admin'); ?>

</p>
<?php //echo $form->error($model, 'admin'); ?>

<p>
    <?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
</p>

<?php $this->endWidget(); ?>