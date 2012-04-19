<?php
$form = $this->beginWidget('CActiveForm', array(
    'id' => 'state-form',
    'enableAjaxValidation' => true,
    'htmlOptions' => array('enctype' => 'multipart/form-data')
        ));
?>

<fieldset>
    <legend>State Information</legend>
    <div class="formrow">
        <?php
        echo $form->labelEx($state, 'name'),
        $form->textField($state, 'name', array('maxlength' => 150, 'class' => 'text'));
        ?>
    </div>
    <?php echo $form->error($state, 'name'); ?>

</fieldset>

<fieldset>
    <legend>State Image</legend>
    <div class="formrow">
        <?php
        if (!$state->isNewRecord) {
            echo CHtml::image('_game/states/' . $state->image);
        }

        echo $form->fileField($state, 'image');
        ?>
    </div>
    <?php echo $form->error($state, 'image'); ?>
</fieldset>

<p>
    <?php
    echo CHtml::submitButton($state->isNewRecord ? 'Create' : 'Save', array('class' => 'button')),
    CHtml::link('Cancel', $this->createUrl('/states'));
    ?>
</p>


<?php
$this->endWidget();