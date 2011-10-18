<?php
$form = $this->beginWidget('CActiveForm', array(
    'id' => 'login-form',
    'enableClientValidation' => false
        )
);

//TODO: validation errors
//$htmlOptions = array('class' => 'span-10 last');
?>
<fieldset>
    <legend>Login</legend>
    <p>
        <?php
        echo $form->labelEx($login, 'email'), '<br />',
        $form->textField($login, 'email', array('class' => 'text'))
        ?>
    </p>
    <?php //echo $form->error($login, 'email'); ?>
    <p>
        <?php
        echo $form->labelEx($login, 'password'), '<br />',
        $form->passwordField($login, 'password', array('class' => 'text'));
        ?>
    </p>
    <?php //echo $form->error($login, 'password'); ?>
    <p>
        <?php
        echo $form->checkBox($login, 'rememberMe'), '&nbsp;',
        $form->label($login, 'rememberMe');
        ?>
    </p>
    <?php //echo $form->error($login, 'rememberMe'); ?>
    <p>
        <?php echo CHtml::submitButton('Login'); ?>
    </p>
</fieldset>
<?php $this->endWidget(); ?>