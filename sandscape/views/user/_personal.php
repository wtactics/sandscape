<?php
$form = $this->beginWidget('CActiveForm', array(
    'id' => 'profile-form',
    'enableClientValidation' => true,
    'clientOptions' => array(
        'validateOnSubmit' => true,
        'validateOnChange' => true,
        'validateOnType' => false,
        ))
);
?>
<?php //echo $form->errorSummary($user);    ?>
<fieldset>
    <legend>General information</legend>
    <p>
        <?php
        echo $form->labelEx($user, 'name'), '<br />',
        $form->textField($user, 'name', array('size' => 60, 'maxlength' => 100, 'class' => 'text'));
        ?>
    </p>
    <?php //echo $form->error($user, 'name'); ?>
    <p>
        <?php
        echo $form->labelEx($user, 'email'), '<br />',
        $form->textField($user, 'email', array('size' => 60, 'maxlength' => 255, 'class' => 'text'));
        ?>
    </p>
    <?php //echo $form->error($user, 'email'); ?>
    <p>
        <?php
        echo $form->checkBox($user, 'seeTopDown'), '&nbsp;', $form->labelEx($user, 'seeTopDown');
        ?>
    </p>
    <?php //echo $form->error($user, 'seeTopDown'); ?>
</fieldset>
<p>
    <?php echo CHtml::submitButton('Save'); ?>
</p>
<?php $this->endWidget(); ?>