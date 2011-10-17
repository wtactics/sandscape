<?php
$form = $this->beginWidget('CActiveForm', array(
    'id' => 'recover-form',
    'enableClientValidation' => false
        )
);
?>

<div class="span-22 append-1 prepend-1 last">
    <fieldset>
        <label>Request new password</label>
        <p>
            <?php echo $form->labelEx($recover, 'email'), '<br />', $form->textField($recover, 'email', array('class' => 'text')); ?>
        </p>
        <p>
            <?php echo CHtml::submitButton('Send'); ?>
        </p>
    </fieldset>
</div>

<?php $this->endWidget(); ?>