<?php
/** @var BootActiveForm $form */
$form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
    'id' => 'verticalForm',
    'htmlOptions' => array('class' => 'well'),
    'enableAjaxValidation' => true
        ));
?>

<?php echo $form->textFieldRow($model, 'textField', array('class' => 'span3')); ?>
<?php echo $form->passwordFieldRow($model, 'password', array('class' => 'span3')); ?>
<?php echo $form->checkboxRow($model, 'checkbox'); ?>
<?php $this->widget('bootstrap.widgets.TbButton', array('buttonType' => 'submit', 'label' => 'Login')); ?>

<?php $this->endWidget(); ?>

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