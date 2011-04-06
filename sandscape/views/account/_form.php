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
        <div class="leftformcolum"><?php echo CHtml::label('Password', 'password'); ?></div>
        <div class="rightformcolum"><?php echo CHtml::passwordField('password'); ?></div>
    </div>
    
    <div class="row">
        <div class="leftformcolum"><?php echo CHtml::label('Repeat Password', 'passwordmatch'); ?></div>
        <div class="rightformcolum"><?php echo CHtml::passwordField('password'); ?></div>
    </div>

    <div class="row">
        <div class="leftformcolum"><?php echo $form->labelEx($model, 'emailVisibility'); ?></div>
        <div class="rightformcolum"><?php echo $form->dropDownList($model, 'emailVisibility', array('Only administrators', 'Everyone')); ?></div>
        <div class="formfielderror"><?php echo $form->error($model, 'emailVisibility'); ?></div>
    </div>

    <div class="row">
        <div class="leftformcolum"><?php echo $form->labelEx($model, 'acceptMessages'); ?></div>
        <div class="rightformcolum"><?php
        echo $form->dropDownList($model, 'acceptMessages', array(
            'Don\'t send me e-mails', 'Only from administrators', 'Everyone can send me an e-mail'
        ));
        ?></div>
        <div class="formfielderror"><?php echo $form->error($model, 'acceptMessages'); ?></div>
    </div>

    <div class="row buttons">
        <?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
    </div>

    <?php $this->endWidget(); ?>

</div><!-- form -->