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
        <?php echo $form->labelEx($model, 'name'); ?>
        <?php echo $form->textField($model, 'name', array('size' => 20, 'maxlength' => 20)); ?>
        <?php echo $form->error($model, 'name'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'password'); ?>
        <?php echo $form->passwordField($model, 'password', array('size' => 40, 'maxlength' => 40)); ?>
        <?php echo $form->error($model, 'password'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'email'); ?>
        <?php echo $form->textField($model, 'email', array('size' => 60, 'maxlength' => 200)); ?>
        <?php echo $form->error($model, 'email'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'key'); ?>
        <?php echo $form->textField($model, 'key', array('size' => 40, 'maxlength' => 40)); ?>
        <?php echo $form->error($model, 'key'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'emailVisibility'); ?>
        <?php echo $form->checkBox($model, 'emailVisibility'); ?>
        <?php echo $form->error($model, 'emailVisibility'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'acceptMessages'); ?>
        <?php
        echo $form->dropDownList($model, 'acceptMessages', array(
            'Don\'t send me e-mails', 'Only from administrators', 'Everyone can send me an e-mail'
        ));
        ?>
        <?php echo $form->error($model, 'acceptMessages'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'admin'); ?>
        <?php echo $form->textField($model, 'admin'); ?>
        <?php echo $form->error($model, 'admin'); ?>
    </div>

    <div class="row buttons">
        <?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
    </div>

    <?php $this->endWidget(); ?>

</div><!-- form -->