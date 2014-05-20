<?php

/** @var DiceController $this */
$form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
    'id' => 'user-form',
    'layout' => TbHtml::FORM_LAYOUT_HORIZONTAL,
    'enableAjaxValidation' => true
        ));

echo $form->textFieldControlGroup($dice, 'name', array('maxlength' => 150, 'class' => 'span6')),
 $form->textFieldControlGroup($dice, 'face', array('class' => 'input-small')),
 $form->checkBoxControlGroup($dice, 'enabled'),
 $form->textAreaControlGroup($dice, 'description', array('span' => '6', 'rows' => 3));

echo TbHtml::formActions(array(
    TbHtml::submitButton('Submit', array('color' => TbHtml::BUTTON_COLOR_PRIMARY)),
    TbHtml::button('Cancel')
));

$this->endWidget();
