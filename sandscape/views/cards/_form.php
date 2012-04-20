<?php
$form = $this->beginWidget('CActiveForm', array(
    'id' => 'card-form',
    'enableAjaxValidation' => true,
    'htmlOptions' => array('enctype' => 'multipart/form-data')
        ));
?>
<div style="float: left; width: 60%;">
    <fieldset>
        <legend>Card Info</legend>
        <div class="formrow">
            <?php
            echo $form->labelEx($card, 'name'),
            $form->textField($card, 'name', array('maxlength' => 150, 'class' => 'large'));
            ?>
        </div>

        <?php echo $form->error($card, 'name'); ?>
        <div class="formrow">
            <?php
            echo $form->labelEx($card, 'cardscapeId'),
            $form->textField($card, 'cardscapeId', array('class' => 'numeric'));
            ?>
        </div>
        <?php echo $form->error($card, 'cardscapeId'); ?>

        <div class="formrow">
            <?php
            echo $form->labelEx($card, 'rules'),
            $form->textArea($card, 'rules', array('class' => 'large'));
            ?>
        </div>
        <?php echo $form->error($card, 'rules'); ?>
    </fieldset>
</div>

<div style="float:right; width: 38%;text-align: center;">
    <fieldset>
        <legend>Card Image</legend>
        <div class="formrow">
            <?php
            if (!$card->isNewRecord) {
                echo CHtml::image('_game/cards/' . $card->image);
            }
            ?>
            <br />
            <?php echo $form->fileField($card, 'image'); ?>
        </div>
        <?php echo $form->error($card, 'image'); ?>
    </fieldset>
</div>
<div class="clearfix"></div>

<div class="buttonrow">
    <?php
    echo CHtml::submitButton($card->isNewRecord ? 'Create' : 'Save', array('class' => 'button')),
    CHtml::link('Cancel', $this->createUrl('cards/index'));
    ?>
</div>

<?php
$this->endWidget();