<div class="span-24">
    <h2>Recover Password</h2>
    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'recover-form',
        'enableClientValidation' => false
            )
    );
    ?>

    <fieldset>
        <legend>Request new password</legend>
        <p>
            <?php echo $form->labelEx($recover, 'email'), '<br />', $form->textField($recover, 'email', array('class' => 'text')); ?>
        </p>
    </fieldset>
    <p>
        <?php echo CHtml::submitButton('Send'); ?>
    </p>
    <?php $this->endWidget(); ?>
</div>