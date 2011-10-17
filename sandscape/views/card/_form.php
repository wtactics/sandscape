<?php

$form = $this->beginWidget('CActiveForm', array(
    'id' => 'card-form',
    'enableAjaxValidation' => false,
        ));
?>

<?php echo $form->errorSummary($card); ?>


<?php echo $form->labelEx($card, 'name'); ?>
<?php echo $form->textField($card, 'name', array('size' => 60, 'maxlength' => 150)); ?>
<?php echo $form->error($card, 'name'); ?>



<?php echo $form->labelEx($card, 'rules'); ?>
<?php echo $form->textArea($card, 'rules', array('rows' => 6, 'cols' => 50)); ?>
<?php echo $form->error($card, 'rules'); ?>



<?php echo $form->labelEx($card, 'image'); ?>
<?php echo $form->textField($card, 'image', array('size' => 36, 'maxlength' => 36)); ?>
<?php echo $form->error($card, 'image'); ?>



<?php echo $form->labelEx($card, 'cardscapeId'); ?>
<?php echo $form->textField($card, 'cardscapeId', array('size' => 10, 'maxlength' => 10)); ?>
<?php echo $form->error($card, 'cardscapeId'); ?>



<?php echo $form->labelEx($card, 'active'); ?>
<?php echo $form->textField($card, 'active'); ?>
<?php echo $form->error($card, 'active'); ?>



<?php echo CHtml::submitButton($card->isNewRecord ? 'Create' : 'Save'); ?>


<?php $this->endWidget(); ?>
