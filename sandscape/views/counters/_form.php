<?php

/** @var CountersController $this */
/** @var $form TbActiveForm */
$form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
    'id' => 'user-form',
    'layout' => TbHtml::FORM_LAYOUT_HORIZONTAL,
    'enableAjaxValidation' => true
        ));

echo $form->textFieldControlGroup($counter, 'name', array('maxlength' => 150)),
 $form->textFieldControlGroup($counter, 'startValue'),
 $form->textFieldControlGroup($counter, 'step'),
 $form->checkBoxControlGroup($counter, 'enabled');

$buttons = array(TbHtml::submitButton('Submit', array('color' => TbHtml::BUTTON_COLOR_SUCCESS)));
if (!$counter->isNewRecord) {
    $buttons[] = TbHtml::linkButton('Add New', array('url' => array('new'), 'color' => TbHtml::BUTTON_COLOR_INFO));
}
$buttons[] = TbHtml::linkButton('Cancel', array('url' => array('index')));

echo TbHtml::formActions($buttons);

$this->endWidget();
