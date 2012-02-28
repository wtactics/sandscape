<?php
$form = $this->beginWidget('CActiveForm', array(
    'id' => 'password-form',
    'enableAjaxValidation' => true
        ));
?>
<fieldset>
    <legend>Password</legend>
    <div class="formrow">
        <?php
        echo $form->labelEx($pmodel, 'current'),
        $form->passwordField($pmodel, 'current', array('class' => 'text'));
        ?>
    </div>
    <?php echo $form->error($pmodel, 'current'); ?>

    <div class="formwor">
        <?php
        echo $form->labelEx($pmodel, 'password'),
        $form->passwordField($pmodel, 'password', array('class' => 'text'));
        ?>
    </div>
    <?php echo $form->error($pmodel, 'password'); ?>

    <div class="formrow">
        <?php
        echo $form->labelEx($pmodel, 'password_repeat'),
        $form->passwordField($pmodel, 'password_repeat', array('class' => 'text'));
        ?>
    </div>
    <?php echo $form->error($pmodel, 'password_repeat'); ?>
</fieldset>
<div class="buttonrow">
    <?php echo CHtml::submitButton('Save', array('class' => 'button')); ?>
</div>
<?php
$this->endWidget();