<?php
$form = $this->beginWidget('CActiveForm', array(
    'id' => 'token-form',
    'enableAjaxValidation' => true,
    'htmlOptions' => array('enctype' => 'multipart/form-data')
        ));
?>

<div class="span-13">
    <fieldset>
        <legend>Token Information</legend>
        <div class="formrow">
            <?php
            echo $form->labelEx($token, 'name'),
            $form->textField($token, 'name', array('maxlength' => 150, 'class' => 'text'));
            ?>
        </div>
        <?php echo $form->error($token, 'name'); ?>

    </fieldset>
</div>
<div class="span-9 last">
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

<div class="span-20 last">
    <p>
        <?php
        echo CHtml::submitButton($token->isNewRecord ? 'Create' : 'Save', array('class' => 'button')),
        CHtml::link('Cancel', $this->createUrl('/tokens'));
        ?>
    </p>
</div>

<?php
$this->endWidget();