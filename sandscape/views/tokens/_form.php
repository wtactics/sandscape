<?php
$form = $this->beginWidget('CActiveForm', array(
    'id' => 'token-form',
    'enableAjaxValidation' => true,
    'htmlOptions' => array('enctype' => 'multipart/form-data')
        ));
?>

<div style="float: left; width: 60%;">
    <fieldset>
        <legend>Token Information</legend>
        <div class="formrow">
            <?php
            echo $form->labelEx($token, 'name'),
            $form->textField($token, 'name', array('maxlength' => 150, 'class' => 'large'));
            ?>
        </div>
        <?php echo $form->error($token, 'name'); ?>
    </fieldset>
</div>

<div style="float:right; width: 38%;text-align: center;">
    <fieldset>
        <legend>Token Image</legend>
        <div class="formrow">
            <?php
            if (!$token->isNewRecord) {
                echo CHtml::image('_game/tokens/' . $token->image);
            }
            ?>
            <?php echo $form->fileField($token, 'image'); ?>
        </div>
        <?php echo $form->error($token, 'image'); ?>
    </fieldset>
</div>
<div class="clearfix"></div>
<div class="buttonrow">
    <?php
    echo CHtml::submitButton('Save', array('class' => 'button')),
    CHtml::link('Cancel', $this->createUrl('tokens/index'));
    ?>
</div>

<?php
$this->endWidget();