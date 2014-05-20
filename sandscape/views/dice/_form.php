<?php

/** @var DiceController $this */
/** @var $form TbActiveForm */
$form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
    'id' => 'user-form',
    'layout' => TbHtml::FORM_LAYOUT_HORIZONTAL,
    'enableAjaxValidation' => true
        ));

echo $form->textFieldControlGroup($dice, 'name', array('maxlength' => 150, 'class' => 'span6')),
 $form->textFieldControlGroup($dice, 'face', array('class' => 'input-small')),
 $form->checkBoxControlGroup($dice, 'enabled'),
 $form->textAreaControlGroup($dice, 'description', array('span' => '6', 'rows' => 3));

$buttons = array(TbHtml::submitButton('Submit', array('color' => TbHtml::BUTTON_COLOR_SUCCESS)));
if (!$dice->isNewRecord) {
    $buttons[] = TbHtml::linkButton('Add New', array('url' => array('new'), 'color' => TbHtml::BUTTON_COLOR_INFO));
}
$buttons[] = TbHtml::linkButton('Cancel', array('url' => array('index')));

echo TbHtml::formActions($buttons);

$this->endWidget();
