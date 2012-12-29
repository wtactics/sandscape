<?php
$form = $this->beginWidget('CActiveForm', array(
    'id' => 'state-form',
    'enableAjaxValidation' => true,
    'htmlOptions' => array('enctype' => 'multipart/form-data')
        ));
?>

<div style="float: left; width: 60%;">
    <fieldset>
        <legend>State Information</legend>
        <div class="formrow">
            <?php
            echo $form->labelEx($state, 'name'),
            $form->textField($state, 'name', array('maxlength' => 150, 'class' => 'large'));
            ?>
        </div>
        <?php echo $form->error($state, 'name'); ?>
    </fieldset>
</div>

<div style="float:right; width: 38%;text-align: center;">
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
</div>
<div class="clearfix"></div>

<div class="buttonrow">
    <?php
    echo CHtml::submitButton('Save', array('class' => 'button')),
    CHtml::link('Cancel', $this->createUrl('states/index'));
    ?>
</div>

<?php
$this->endWidget();