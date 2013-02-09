<?php
/** @var BootActiveForm $form */
$form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
    'id' => 'register-form',
    'type' => 'vertical',
    'htmlOptions' => array('class' => 'well')
        ));
?>

<p><?php echo Yii::t('sandscape', 'Don\'t have an account yet, register a new account and start playing.'); ?></p>

<?php
echo $form->textFieldRow($register, 'name'),
 $form->textFieldRow($register, 'email'),
 $form->passwordFieldRow($register, 'password'),
 $form->passwordFieldRow($register, 'password_repeat');
?>

<div class="clearfix"></div>

<?php
$this->widget('bootstrap.widgets.TbButton', array(
    'buttonType' => 'submit',
    'label' => 'Register'
));

$this->endWidget();