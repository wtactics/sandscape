<div class="form" style="width: 50%; margin: 0 auto;">
    <?php
    $form = $this->beginWidget('CActiveForm', array(
                'id' => 'login-form'
            ));
    ?>

    <p class="note">Fields with <span class="required">*</span> are required.</p>

    <div class="row">
        
        <div class="leftformcolum"><?php echo $form->labelEx($model, 'email'); ?></div>
        <div class="rightformcolum"><?php echo $form->textField($model, 'email'); ?></div>
        <div class="formfielderror"><?php echo $form->error($model, 'email'); ?></div>
    </div>

    <div class="row">
        <div class="leftformcolum"><?php echo $form->labelEx($model, 'password'); ?></div>
        <div class="rightformcolum"><?php echo $form->passwordField($model, 'password'); ?></div>
        <div class="formfielderror"><?php echo $form->error($model, 'password'); ?></div>
    </div>

    <div class="row rememberMe">
        <div class="leftformcolum"><?php echo $form->checkBox($model, 'rememberMe'); ?></div>
        <div class="rightformcolum"><?php echo $form->label($model, 'rememberMe'); ?></div>
        <div class="formfielderror"><?php echo $form->error($model, 'rememberMe'); ?></div>
    </div>

    <div class="row buttons">
        <?php echo CHtml::submitButton('Login'); ?>
    </div>

    <?php $this->endWidget(); ?>
</div><!-- form -->
