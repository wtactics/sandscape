<?php
$form = $this->beginWidget('CActiveForm', array(
    'id' => 'profile-form',
    'enableAjaxValidation' => true,
    'clientOptions' => array(
        'inputContainer' => 'p'
        )));
?>
<fieldset>
    <legend>General information</legend>
    <p>
        <?php
        echo $form->labelEx($user, 'name'), '<br />',
        $form->textField($user, 'name', array('maxlength' => 15, 'class' => 'text'));
        ?>
    </p>
    <?php echo $form->error($user, 'name'); ?>
    <p>
        <?php
        echo $form->labelEx($user, 'email'), '<br />',
        $form->textField($user, 'email', array('maxlength' => 255, 'class' => 'text'));
        ?>
    </p>
    <?php echo $form->error($user, 'email'); ?>
</fieldset>
<p>
    <?php echo CHtml::submitButton('Save', array('class' => 'button')); ?>
</p>
<fieldset>
    <legend>Profile information</legend>
    <p>
        <?php
        echo $form->labelEx($user, 'birthday'), '<br />';
        ?>
    </p>
    <?php echo $form->error($user, 'birthday'); ?>
    <p>
        <?php
        echo $form->labelEx($user, 'gender'), '<br />',
        $form->dropDownList($user, 'gender', array());
        ?>
    </p>
    <?php echo $form->error($user, 'gender'); ?>
    <p>
        <?php
        echo $form->labelEx($user, 'website'), '<br />',
        $form->textField($user, 'website', array('maxlength' => 255, 'class' => 'text'));
        ?>
    </p>
    <?php echo $form->error($user, 'website'); ?>
    <p>
        <?php
        echo $form->labelEx($user, 'twitter'), '<br />',
        $form->textField($user, 'twitter', array('maxlength' => 255, 'class' => 'text'));
        ?>
    </p>
    <?php echo $form->error($user, 'twitter'); ?>
    <p>
        <?php
        echo $form->labelEx($user, 'facebook'), '<br />',
        $form->textField($user, 'facebook', array('maxlength' => 255, 'class' => 'text'));
        ?>
    </p>
    <?php echo $form->error($user, 'facebook'); ?>
    <p>
        <?php
        echo $form->labelEx($user, 'googleplus'), '<br />',
        $form->textField($user, 'googleplus', array('maxlength' => 255, 'class' => 'text'));
        ?>
    </p>
    <?php echo $form->error($user, 'googleplus'); ?>
    <p>
        <?php
        echo $form->labelEx($user, 'skype'), '<br />',
        $form->textField($user, 'skype', array('maxlength' => 255, 'class' => 'text'));
        ?>
    </p>
    <?php echo $form->error($user, 'skype'); ?>
    <p>
        <?php
        echo $form->labelEx($user, 'msn'), '<br />',
        $form->textField($user, 'msn', array('maxlength' => 255, 'class' => 'text'));
        ?>
    </p>
    <?php echo $form->error($user, 'msn'); ?>
</fieldset>
<p>
    <?php echo CHtml::submitButton('Save', array('class' => 'button')); ?>
</p>
<?php
$this->endWidget();
