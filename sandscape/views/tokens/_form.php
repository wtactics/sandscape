<?php
$form = $this->beginWidget('CActiveForm', array(
    'id' => 'token-form',
    'enableAjaxValidation' => true,
    'clientOptions' => array(
        'inputContainer' => 'p'
    ),
    'htmlOptions' => array('enctype' => 'multipart/form-data')
        ));
?>

<div class="span-13">
    <fieldset>
        <legend>Token Information</legend>
        <p>
            <?php
            echo $form->labelEx($token, 'name'), '<br />',
            $form->textField($token, 'name', array('maxlength' => 150, 'class' => 'text'));
            ?>
        </p>
        <?php echo $form->error($token, 'name'); ?>

    </fieldset>
</div>
<div class="span-9 last">
    <fieldset>
        <legend>Token Image</legend>
        <?php
        if (!$token->isNewRecord) {
            echo CHtml::image('_game/tokens/' . $token->image);
        }
        ?>
        <p>
            <?php echo $form->fileField($token, 'image'); ?>
        </p>
        <?php echo $form->error($token, 'image'); ?>
    </fieldset>
</div>
<div class="span-20 last">
    <p>
        <?php echo CHtml::submitButton($token->isNewRecord ? 'Create' : 'Save', array('class' => 'button')); ?>
    </p>
</div>

<?php
$this->endWidget();