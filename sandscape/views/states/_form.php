<?php
$form = $this->beginWidget('CActiveForm', array(
    'id' => 'state-form',
    'enableAjaxValidation' => true,
    'clientOptions' => array(
        'inputContainer' => 'p'
    ),
    'htmlOptions' => array('enctype' => 'multipart/form-data')
        ));
?>

<div class="span-13">
    <fieldset>
        <legend>State Information</legend>
        <p>
            <?php
            echo $form->labelEx($state, 'name'), '<br />',
            $form->textField($state, 'name', array('maxlength' => 150, 'class' => 'text'));
            ?>
        </p>
        <?php echo $form->error($state, 'name'); ?>

    </fieldset>
</div>
<div class="span-9 last">
    <fieldset>
        <legend>State Image</legend>
        <?php
        if (!$state->isNewRecord) {
            echo CHtml::image('_game/states/' . $state->image);
        }
        ?>
        <p>
            <?php echo $form->fileField($state, 'image'); ?>
        </p>
        <?php echo $form->error($state, 'image'); ?>
    </fieldset>
</div>
<div class="span-20 last">
    <p>
        <?php echo CHtml::submitButton($state->isNewRecord ? 'Create' : 'Save', array('class' => 'button')); ?>
    </p>
</div>

<?php
$this->endWidget();