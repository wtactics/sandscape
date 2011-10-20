<?php
$form = $this->beginWidget('CActiveForm', array(
    'id' => 'password-form',
    'enableClientValidation' => false
        ));
?>
<fieldset>
    <legend>Password</legend>
    <p>
        <?php
        echo $form->labelEx($pwdModel, 'current'), '<br />',
        $form->passwordField($pwdModel, 'current', array('class' => 'text'));
        ?>
    </p>
    <p>
        <?php
        echo $form->labelEx($pwdModel, 'password'), '<br />',
        $form->passwordField($pwdModel, 'password', array('class' => 'text'));
        ?>
    </p>
    <p>
        <?php
        echo $form->labelEx($pwdModel, 'password_repeat'), '<br />',
        $form->passwordField($pwdModel, 'password_repeat', array('class' => 'text'));
        ?>
    </p>
</fieldset>
<p>
    <?php echo CHtml::submitButton('Save'); ?>
</p>
<?php $this->endWidget(); ?>