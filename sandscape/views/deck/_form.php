<?php
$form = $this->beginWidget('CActiveForm', array(
    'id' => 'deck-form',
    'enableAjaxValidation' => false,
        ));
?>

<?php echo $form->errorSummary($deck); ?>

<fieldset>
    <p>
        <?php
        echo $form->labelEx($deck, 'name'), '<br />',
        $form->textField($deck, 'name', array('size' => 60, 'maxlength' => 100, 'class' => 'text'));
        ?>
    </p>
    <?php echo $form->error($deck, 'name'); ?>
    <p>
        <?php echo CHtml::submitButton($deck->isNewRecord ? 'Create' : 'Save'); ?>
    </p>
</fieldset>
<?php $this->endWidget(); ?>
