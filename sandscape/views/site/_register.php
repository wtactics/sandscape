<?php
$form = $this->beginWidget('CActiveForm', array(
    'id' => 'register-form',
    'enableClientValidation' => true,
    'clientOptions' => array(
        'validateOnSubmit' => true,
        'validateOnChange' => true,
        'validateOnType' => false,
    )
        )
);

//TODO: validation errors
//$htmlOptions = array('class' => 'span-10 last');
?>
<div class="span-10 prepend-1">
    <fieldset>
        <legend>Register new account</legend>
        <p>Don't have an account yet, register a new account and start playing.</p>
        <p>
            <?php
            echo $form->labelEx($register, 'name'), '<br />',
            $form->textField($register, 'name', array('class' => 'text'));
            ?>
        </p>
        <?php //echo $form->error($register, 'name', $htmlOptions); ?>

        <p>
            <?php
            echo $form->labelEx($register, 'email'), '<br />',
            $form->textField($register, 'email', array('class' => 'text'));
            ?>
        </p>
        <?php //echo $form->error($register, 'email', $htmlOptions); ?>
        <p>
            <?php
            echo $form->labelEx($register, 'password'), '<br />',
            $form->passwordField($register, 'password', array('class' => 'text'));
            ?>
        </p>
        <?php //echo $form->error($register, 'password', $htmlOptions); ?>
        <p>
            <?php
            echo $form->labelEx($register, 'password_repeat'), '<br />',
            $form->passwordField($register, 'password', array('class' => 'text'));
            ?>
        </p>
        <?php //echo $form->error($register, 'password_repeat', $htmlOptions); ?>
        <p>
            <?php echo CHtml::submitButton('Register'); ?>
        </p>
    </fieldset>

</div>
<?php
$this->endWidget();


