<?php $this->title = 'Recover your password'; ?>
<h2>Recover Password</h2>
<?php
$form = $this->beginWidget('CActiveForm', array(
    'id' => 'recover-form',
    'enableClientValidation' => false
        )
);
?>

<div class="span-12 last">
    <fieldset>
        <legend>Request new password</legend>
        <p>
            <?php echo $form->labelEx($recover, 'email'), ':<br />', $form->textField($recover, 'email', array('class' => 'text')); ?>
        </p>
    </fieldset>
    <p>
        <?php echo CHtml::submitButton('Send'); ?>
    </p>
</div>
<?php $this->endWidget(); ?>
