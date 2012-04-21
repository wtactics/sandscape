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
    <div class="formrow">
        <?php
        echo $form->labelEx($register, 'name'),
        $form->textField($register, 'name', array('class' => 'standard'));
        ?>
    </div>
    <?php echo $form->error($register, 'name'); ?>
    <div class="formrow">
        <?php
        echo $form->labelEx($register, 'email'),
        $form->textField($register, 'email', array('class' => 'standard'));
        ?>
    </div>
    <?php echo $form->error($register, 'email'); ?>
    <div class="formrow">
        <?php
        echo $form->labelEx($register, 'password'),
        $form->passwordField($register, 'password', array('class' => 'standard'));
        ?>
    </div>
    <?php echo $form->error($register, 'password'); ?>
    <div class="formrow">
        <?php
        echo $form->labelEx($register, 'password_repeat'),
        $form->passwordField($register, 'password_repeat', array('class' => 'standard'));
        ?>
    </div>
    <?php echo $form->error($register, 'password_repeat'); ?>
</fieldset>

<div class="buttonrow">
    <?php echo CHtml::submitButton('Register', array('class' => 'button')); ?>
</div>
<?php
$this->endWidget();