
<h2>Register Account</h2>
<?php
$form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
    'id' => 'user-form',
    'layout' => TbHtml::FORM_LAYOUT_HORIZONTAL,
        ));

echo $form->textFieldControlGroup($register, 'name'),
 $form->textFieldControlGroup($register, 'email'),
 $form->textFieldControlGroup($register, 'password'),
 $form->textFieldControlGroup($register, 'password2');

echo TbHtml::submitButton('Submit', array('color' => TbHtml::BUTTON_COLOR_PRIMARY));

$this->endWidget();
