<?php
$form = $this->beginWidget('CActiveForm', array(
    'id' => 'profile-form',
    'enableAjaxValidation' => true,
    'clientOptions' => array(
        'inputContainer' => 'p'
        )));
?>
<fieldset>
    <legend>General information</legend>
    <p>
        <?php
        echo $form->labelEx($user, 'name'), '<br />',
        $form->textField($user, 'name', array('size' => 25, 'maxlength' => 15, 'class' => 'text'));
        ?>
    </p>
    <?php echo $form->error($user, 'name'); ?>
    <p>
        <?php
        echo $form->labelEx($user, 'email'), '<br />',
        $form->textField($user, 'email', array('size' => 60, 'maxlength' => 255, 'class' => 'text'));
        ?>
    </p>
    <?php echo $form->error($user, 'email'); ?>
</fieldset>
<p>
    <?php echo CHtml::submitButton('Save', array('class' => 'button')); ?>
</p>
<?php $this->endWidget(); ?>