<div class="span-24">
    <h2>Edit Profile</h2>
    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'profile-form',
        'enableClientValidation' => true,
        'clientOptions' => array(
            'validateOnSubmit' => true,
            'validateOnChange' => true,
            'validateOnType' => false,
            ))
    );
    ?>
    <?php //echo $form->errorSummary($user);  ?>
    <fieldset>
        <legend>General information</legend>
        <p>
            <?php
            echo $form->labelEx($user, 'name'), '<br />',
            $form->textField($user, 'name', array('size' => 60, 'maxlength' => 100, 'class' => 'text'));
            ?>
        </p>
        <?php //echo $form->error($user, 'name'); ?>
        <p>
            <?php
            echo $form->labelEx($user, 'email'), '<br />',
            $form->textField($user, 'email', array('size' => 60, 'maxlength' => 255, 'class' => 'text'));
            ?>
        </p>
        <?php //echo $form->error($user, 'email'); ?>
        <p>
            <?php
            echo $form->checkBox($user, 'seeTopDown'), '&nbsp;', $form->labelEx($user, 'seeTopDown');
            ?>
        </p>
        <?php //echo $form->error($user, 'seeTopDown'); ?>
    </fieldset>
    <fieldset>
        <legend>Password</legend>
        <p class="notice">If you don't want to change your password, leave the following fields empty.</p>
        <p>
            <?php
            echo $form->labelEx($pwdModel, 'password'), '<br />',
            $form->passwordField($pwdModel, 'password', array('class' => 'text'));
            ?>
        </p>
        <p>
            <?php
            echo $form->labelEx($pwdModel, 'password_repeat'), '<br />',
            $form->passwordField($pwdModel, 'password_repeat', array('class' => 'text'));
            ?>
        </p>
    </fieldset>
    <p>
        <?php echo CHtml::submitButton('Save'); ?>
    </p>

    <?php $this->endWidget(); ?>
</div>