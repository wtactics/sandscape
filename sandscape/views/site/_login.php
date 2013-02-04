<?php

/** @var BootActiveForm $form */
/** @var SiteController $this */
$form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
    'id' => 'login-form',
    'type' => 'vertical',
    'htmlOptions' => array('class' => 'well'),
    'focus' => array($login, 'email'),
        ));

echo $form->textFieldRow($login, 'email');

echo $form->passwordFieldRow($login, 'password');

echo $form->checkboxRow($login, 'rememberMe');

$this->widget('bootstrap.widgets.TbButton', array(
    'buttonType' => 'submit',
    'label' => 'Login'
));

$this->endWidget();