<h2>Login</h2>
<?php

$form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
    'id' => 'user-form',
    'layout' => TbHtml::FORM_LAYOUT_HORIZONTAL,
        ));

echo $form->textFieldControlGroup($login, 'email'),
 $form->textFieldControlGroup($login, 'password'),
 $form->checkBoxControlGroup($login, 'rememberMe');

echo TbHtml::submitButton('Submit', array('color' => TbHtml::BUTTON_COLOR_PRIMARY));

$this->endWidget();
