<?php
$form = $this->beginWidget('CActiveForm', array(
    'id' => 'password-form',
    'enableAjaxValidation' => true,
    'clientOptions' => array(
        'inputContainer' => 'p'
    )
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
    <?php echo $form->error($pwdModel, 'current'); ?>
    <p>
        <?php
        echo $form->labelEx($pwdModel, 'password'), '<br />',
        $form->passwordField($pwdModel, 'password', array('class' => 'text'));
        ?>
    </p>
    <?php echo $form->error($pwdModel, 'password'); ?>
    <p>
        <?php
        echo $form->labelEx($pwdModel, 'password_repeat'), '<br />',
        $form->passwordField($pwdModel, 'password_repeat', array('class' => 'text'));
        ?>
    </p>
    <?php echo $form->error($pwdModel, 'password_repeat'); ?>
</fieldset>
<p>
    <?php echo CHtml::submitButton('Change', array('class' => 'button')); ?>
</p>
<?php $this->endWidget(); ?>