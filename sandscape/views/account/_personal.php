<?php
$form = $this->beginWidget('CActiveForm', array(
    'id' => 'profile-form',
    'enableAjaxValidation' => true
        ));
?>
<fieldset>
    <legend>General information</legend>
    <div class="formrow">
        <?php
        echo $form->labelEx($user, 'name'),
        $form->textField($user, 'name', array('maxlength' => 15, 'class' => 'large'));
        ?>
    </div>
    <?php echo $form->error($user, 'name'); ?>

    <div class="formrow">
        <?php
        echo $form->labelEx($user, 'email'),
        $form->textField($user, 'email', array('maxlength' => 255, 'class' => 'large'));
        ?>
    </div>
    <?php echo $form->error($user, 'email'); ?>

    <div class="formrow">
        <?php
        echo $form->labelEx($user, 'reverseCards'), $form->checkBox($user, 'reverseCards');
        ?>
    </div>
    <?php echo $form->error($user, 'reverseCards'); ?>

    <div class="formrow">
        <?php
        echo $form->labelEx($user, 'onHoverDetails'), $form->checkBox($user, 'onHoverDetails');
        ?>
    </div>
    <?php echo $form->error($user, 'onHoverDetails'); ?>
</fieldset>

<fieldset>
    <legend>Profile information</legend>
    <div class="formrow">
        <?php
        echo $form->labelEx($user, 'country'),
        $form->dropDownList($user, 'country', $countries);
        ?>
    </div>
    <?php echo $form->error($user, 'country'); ?>

    <div class="formrow">
        <?php
        echo $form->labelEx($user, 'birthyear'),
        $form->textField($user, 'birthyear', array('maxlength' => 4, 'class' => 'numeric'));
        ?>
    </div>
    <?php echo $form->error($user, 'birthyear'); ?>

    <div class="formrow">
        <?php
        echo $form->labelEx($user, 'gender'),
        $form->dropDownList($user, 'gender', array(0 => 'Female', 1 => 'Male'));
        ?>
    </div>
    <?php echo $form->error($user, 'gender'); ?>

    <div class="formrow">
        <?php
        echo $form->labelEx($user, 'website'),
        $form->textField($user, 'website', array('maxlength' => 255, 'class' => 'large'));
        ?>
    </div>
    <?php echo $form->error($user, 'website'); ?>

    <div class="formrow">
        <?php
        echo $form->labelEx($user, 'twitter'),
        $form->textField($user, 'twitter', array('maxlength' => 255, 'class' => 'large'));
        ?>
    </div>
    <?php echo $form->error($user, 'twitter'); ?>

    <div class="formrow">
        <?php
        echo $form->labelEx($user, 'facebook'),
        $form->textField($user, 'facebook', array('maxlength' => 255, 'class' => 'large'));
        ?>
    </div>
    <?php echo $form->error($user, 'facebook'); ?>

    <div class="formrow">
        <?php
        echo $form->labelEx($user, 'googleplus'),
        $form->textField($user, 'googleplus', array('maxlength' => 255, 'class' => 'large'));
        ?>
    </div>
    <?php echo $form->error($user, 'googleplus'); ?>

    <div class="formrow">
        <?php
        echo $form->labelEx($user, 'skype'),
        $form->textField($user, 'skype', array('maxlength' => 255, 'class' => 'large'));
        ?>
    </div>
    <?php echo $form->error($user, 'skype'); ?>

    <div class="formrow">
        <?php
        echo $form->labelEx($user, 'msn'),
        $form->textField($user, 'msn', array('maxlength' => 255, 'class' => 'large'));
        ?>
    </div>
    <?php echo $form->error($user, 'msn'); ?>
</fieldset>

<div class="buttonrow">
    <?php echo CHtml::submitButton('Save', array('class' => 'button')); ?>
</div>
<?php
$this->endWidget();




