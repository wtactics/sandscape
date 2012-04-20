<?php
$form = $this->beginWidget('CActiveForm', array(
    'id' => 'user-form',
    'enableAjaxValidation' => true
        ));
?>

<fieldset>
    <legend>General information</legend>
    <div class="formrow">
        <?php
        echo $form->labelEx($user, 'name'),
        $form->textField($user, 'name', array('size' => 25, 'maxlength' => 15, 'class' => 'text'));
        ?>
    </div>
    <?php echo $form->error($user, 'name'); ?>

    <div class="formrow">
        <?php
        echo $form->labelEx($user, 'email'),
        $form->textField($user, 'email', array('size' => 60, 'maxlength' => 255, 'class' => 'text'));
        ?>
    </div>
    <?php echo $form->error($user, 'email'); ?>
    <div class="formrow">
        <?php
        echo $form->labelEx($user, 'class', array('class' => 'standard')),
        $form->dropDownList($user, 'class', array(0 => 'Regular', 1 => 'Power User', 2 => 'Administrator'));
        ?>
    </div>
    <?php echo $form->error($user, 'class'); ?>
</fieldset>

<div class="buttonrow">
    <?php
    echo CHtml::submitButton($user->isNewRecord ? 'Create' : 'Save', array('class' => 'button')),
    CHtml::link('Cancel', $this->createUrl('users/index'));
    ?>
</div>
<?php
$this->endWidget();