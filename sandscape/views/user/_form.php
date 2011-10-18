<?php
$form = $this->beginWidget('CActiveForm', array(
    'id' => 'user-form',
    'enableAjaxValidation' => false,
        ));
?>

<?php //echo $form->errorSummary($user); ?>

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
    <?php //echo $form->error($user, 'admin');  ?>
    <p>
        <?php
        echo $form->checkBox($user, 'admin'), '&nbsp;', $form->labelEx($user, 'admin');
        ?>
    </p>
    <?php //echo $form->error($user, 'admin');  ?>
</fieldset>
<p>
    <?php echo CHtml::submitButton($user->isNewRecord ? 'Create' : 'Save'); ?>
</p>

<?php $this->endWidget(); ?>