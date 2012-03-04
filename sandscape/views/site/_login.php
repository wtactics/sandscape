<?php
$form = $this->beginWidget('CActiveForm', array(
    'id' => 'login-form',
    'focus' => array($login, 'email'),
        ));
?>
<fieldset>
    <legend>Login</legend>
    <div class="formrow">
        <?php
        echo $form->labelEx($login, 'email'),
        $form->textField($login, 'email', array('class' => 'text'));
        ?>
    </div>
    <?php echo $form->error($login, 'email'); ?>
    <div class="formrow">
        <?php
        echo $form->labelEx($login, 'password'),
        $form->passwordField($login, 'password', array('class' => 'text'));
        ?>
    </div>
    <?php echo $form->error($login, 'password'); ?>
    <div class="formrow">
        <?php
        echo $form->checkBox($login, 'rememberMe'),
        $form->label($login, 'rememberMe', array('class' => 'standard'));
        ?>
    </div>
    <?php echo $form->error($login, 'rememberMe'); ?>
</fieldset>

<div class="buttonrow">
    <?php echo CHtml::submitButton('Login', array('class' => 'button')); ?>
</div>
<?php
$this->endWidget();