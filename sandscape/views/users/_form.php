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
        <div class="leftformcolum"><?php echo $form->labelEx($model, 'name'); ?></div>
        <div class="rightformcolum"><?php echo $form->textField($model, 'name', array('size' => 20, 'maxlength' => 20)); ?></div>
        <div class="formfielderror"><?php echo $form->error($model, 'name'); ?></div>
    </div>

    <div class="row">
        <div class="leftformcolum"><?php echo $form->labelEx($model, 'email'); ?></div>
        <div class="rightformcolum"><?php echo $form->textField($model, 'email', array('size' => 60, 'maxlength' => 200)); ?></div>
        <div class="formfielderror"><?php echo $form->error($model, 'email'); ?></div>
    </div>

    <div class="row">
        <div class="leftformcolum"><?php echo $form->labelEx($model, 'admin'); ?></div>
        <div class="rightformcolum"><?php echo $form->dropDownList($model, 'admin', array('Regular', 'Administrator')); ?></div>
        <div class="formfielderror"><?php echo $form->error($model, 'admin'); ?></div>
    </div>

    <br />

    <div class="row buttons">
        <?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
    </div>

    <?php $this->endWidget(); ?>

</div><!-- form -->