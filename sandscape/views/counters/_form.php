<?php

/** @var CountersController $this */
$form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
    'id' => 'user-form',
    'layout' => TbHtml::FORM_LAYOUT_HORIZONTAL,
    'enableAjaxValidation' => true
        ));

echo $form->textFieldControlGroup($counter, 'name', array('maxlength' => 150)),
 $form->textFieldControlGroup($counter, 'startValue'),
 $form->textFieldControlGroup($counter, 'step'),
 $form->checkBoxControlGroup($counter, 'enabled');

echo TbHtml::formActions(array(
    TbHtml::submitButton('Submit', array('color' => TbHtml::BUTTON_COLOR_PRIMARY)),
    TbHtml::button('Cancel')
));

$this->endWidget();
