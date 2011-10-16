<div class="form">

    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'user-form',
        'enableAjaxValidation' => false,
            ));
    ?>

    <p class="note">Fields with <span class="required">*</span> are required.</p>

        <?php echo $form->errorSummary($model); ?>

    <div class="row">
        <?php echo $form->labelEx($model, 'email'); ?>
<?php echo $form->textField($model, 'email', array('size' => 60, 'maxlength' => 255)); ?>
<?php echo $form->error($model, 'email'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'password'); ?>
<?php echo $form->passwordField($model, 'password', array('size' => 40, 'maxlength' => 40)); ?>
<?php echo $form->error($model, 'password'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'name'); ?>
<?php echo $form->textField($model, 'name', array('size' => 60, 'maxlength' => 100)); ?>
<?php echo $form->error($model, 'name'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'admin'); ?>
<?php echo $form->textField($model, 'admin'); ?>
<?php echo $form->error($model, 'admin'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'active'); ?>
<?php echo $form->textField($model, 'active'); ?>
<?php echo $form->error($model, 'active'); ?>
    </div>

    <div class="row buttons">
    <?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
    </div>

<?php $this->endWidget(); ?>

</div><!-- form -->