<?php

/** @var StatesController $this */
/** @var $form TbActiveForm */
$form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
    'id' => 'user-form',
    'layout' => TbHtml::FORM_LAYOUT_HORIZONTAL,
    'enableAjaxValidation' => true,
    'htmlOptions' => array('enctype' => 'multipart/form-data')
        ));

echo $form->textFieldControlGroup($state, 'name', array('maxlength' => 150, 'class' => 'span6')),
 $form->fileFieldControlGroup($state, 'image'),
 $form->textAreaControlGroup($state, 'description', array('span' => '6', 'rows' => 3));

$buttons = array(TbHtml::submitButton('Submit', array('color' => TbHtml::BUTTON_COLOR_SUCCESS)));
if (!$state->isNewRecord) {
    $buttons[] = TbHtml::linkButton('Add New', array('url' => array('new'), 'color' => TbHtml::BUTTON_COLOR_INFO));
}
$buttons[] = TbHtml::linkButton('Cancel', array('url' => array('index')));

echo TbHtml::formActions($buttons);

$this->endWidget();
