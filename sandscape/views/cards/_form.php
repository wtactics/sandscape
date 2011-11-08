<?php
$form = $this->beginWidget('CActiveForm', array(
    'id' => 'card-form',
    'enableAjaxValidation' => true,
    'clientOptions' => array(
        'inputContainer' => 'p'
    ),
    'htmlOptions' => array('enctype' => 'multipart/form-data')
        ));
?>

<div class="span-13">
    <fieldset>
        <legend>Card Info</legend>
        <p>
            <?php
            echo $form->labelEx($card, 'name'), '<br />',
            $form->textField($card, 'name', array('maxlength' => 150, 'class' => 'text'));
            ?>
        </p>
        <?php echo $form->error($card, 'name'); ?>
        <p>
            <?php
            echo $form->labelEx($card, 'cardscapeId'), '<br />',
            $form->textField($card, 'cardscapeId', array('class' => 'text'));
            ?>
        <p>
            <?php echo $form->error($card, 'cardscapeId'); ?>
        <p>
            <?php
            echo $form->labelEx($card, 'rules'), '<br />',
            $form->textArea($card, 'rules', array('rows' => 4, 'cols' => 50));
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
            echo CHtml::image('_game/cards/' . $card->image);
        }
        ?>
        <p>
            <?php echo $form->fileField($card, 'image'); ?>
        </p>
        <?php echo $form->error($card, 'image'); ?>
    </fieldset>
</div>
<div class="span-20 last">
    <p>
        <?php echo CHtml::submitButton($card->isNewRecord ? 'Create' : 'Save', array('class' => 'button')); ?>
    </p>
</div>

<?php
$this->endWidget();