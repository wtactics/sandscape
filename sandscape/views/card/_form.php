<?php
$form = $this->beginWidget('CActiveForm', array(
    'id' => 'card-form',
    'enableAjaxValidation' => true,
    'clientOptions' => array(
        'validateOnSubmit' => true,
        'validateOnChange' => true,
        'validateOnType' => false,
    )
        ));
?>

<?php //echo $form->errorSummary($card); ?>
<div class="span-13">
    <fieldset>
        <legend>Card Info</legend>
        <p>
            <?php
            echo $form->labelEx($card, 'name'), '<br />',
            $form->textField($card, 'name', array('size' => 60, 'maxlength' => 150, 'class' => 'text'));
            ?>
        </p>
        <?php //echo $form->error($card, 'name'); ?>
        <p>
            <?php
            echo $form->labelEx($card, 'cardscapeId'), '<br />',
            $form->textField($card, 'cardscapeId', array('size' => 10, 'class' => 'text'));
            ?>
        <p>
            <?php //echo $form->error($card, 'cardscapeId'); ?>
        <p>
            <?php
            echo $form->labelEx($card, 'rules'), '<br />',
            $form->textArea($card, 'rules', array('rows' => 4, 'cols' => 50, 'class' => 'text'));
            ?>
        </p>
        <?php echo $form->error($card, 'rules'); ?>
    </fieldset>
</div>
<div class="span-9 last">
    <fieldset>
        <legend>Card Image</legend>
        <?php
        if (!$card->isNewRecord) {
            echo CHtml::image('_cards/up/' . $card->image);
        }
        ?>
        <p>
            <?php
            //TODOD: customize
            $this->widget('CMultiFileUpload', array(
                'name' => 'images',
                'accept' => 'jpg|png',
                'duplicate' => 'Duplicate file!',
                'denied' => 'Invalid file type',
            ));
            ?>
        </p>
        <?php //echo $form->error($card, 'image');  ?>
    </fieldset>
</div>
<div class="span-20 last">
    <p>
        <?php echo CHtml::submitButton($card->isNewRecord ? 'Create' : 'Save'); ?>
    </p>
</div>

<?php $this->endWidget(); ?>
