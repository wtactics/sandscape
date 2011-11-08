<?php
$form = $this->beginWidget('CActiveForm', array(
    'id' => 'login-form',
    'focus' => array($login, 'email'),
        ));
?>
<fieldset>
    <legend>Login</legend>
    <p>
        <?php
        echo $form->labelEx($login, 'email'), '<br />',
        $form->textField($login, 'email', array('class' => 'text'))
        ?>
    </p>
    <?php echo $form->error($login, 'email'); ?>
    <p>
        <?php
        echo $form->labelEx($login, 'password'), '<br />',
        $form->passwordField($login, 'password', array('class' => 'text'));
        ?>
        <?php echo $form->error($login, 'password'); ?>
    </p>

    <p>
        <?php
        echo $form->checkBox($login, 'rememberMe'), '&nbsp;',
        $form->label($login, 'rememberMe');
        ?>
    </p>
    <?php echo $form->error($login, 'rememberMe'); ?>
</fieldset>
<p>
    <?php echo CHtml::submitButton('Login', array('class' => 'button')); ?>
</p>
<?php
$this->endWidget();