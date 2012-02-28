<?php
$form = $this->beginWidget('CActiveForm', array(
    'id' => 'user-form',
    'enableAjaxValidation' => true,
    'clientOptions' => array(
        'inputContainer' => 'p'
    )
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
        echo $form->checkBox($user, 'admin'), '&nbsp;', $form->labelEx($user, 'admin');
        ?>
    </div>
</fieldset>

<div class="formrow">
    <?php
    echo CHtml::submitButton($user->isNewRecord ? 'Create' : 'Save', array('class' => 'button')),
    CHtml::link('Cancel', $this->createUrl('/users'));

    ;
    ?>
</div>
<?php
$this->endWidget();