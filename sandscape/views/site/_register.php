<?php
$form = $this->beginWidget('CActiveForm', array(
    'id' => 'register-form',
    'enableAjaxValidation' => true,
    'clientOptions' => array(
        'inputContainer' => 'p' 
    )
        ));
?>
<fieldset>
    <legend>Register new account</legend>
    <p>Don't have an account yet, register a new account and start playing.</p>
    <p>
        <?php
        echo $form->labelEx($register, 'name'), '<br />',
        $form->textField($register, 'name', array('class' => 'text'));
        ?>
    </p>
    <?php echo $form->error($register, 'name'); ?>
    <p>
        <?php
        echo $form->labelEx($register, 'email'), '<br />',
        $form->textField($register, 'email', array('class' => 'text'));
        ?>
    </p>
    <?php echo $form->error($register, 'email'); ?>
    <p>
        <?php
        echo $form->labelEx($register, 'password'), '<br />',
        $form->passwordField($register, 'password', array('class' => 'text'));
        ?>
    </p>
    <?php echo $form->error($register, 'password'); ?>
    <p>
        <?php
        echo $form->labelEx($register, 'password_repeat'), '<br />',
        $form->passwordField($register, 'password_repeat', array('class' => 'text'));
        ?>
    </p>
    <?php echo $form->error($register, 'password_repeat'); ?>
</fieldset>
<p>
    <?php echo CHtml::submitButton('Register', array('class' => 'button')); ?>
</p>
<?php
$this->endWidget();