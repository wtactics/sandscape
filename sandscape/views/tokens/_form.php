<?php

/** @var $this TokensController */
/** @var $form TbActiveForm */
$form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
    'id' => 'user-form',
    'layout' => TbHtml::FORM_LAYOUT_HORIZONTAL,
    'enableAjaxValidation' => true,
    'htmlOptions' => array('enctype' => 'multipart/form-data')
        ));

echo $form->textFieldControlGroup($token, 'name', array('maxlength' => 150, 'class' => 'span6')),
 $form->fileFieldControlGroup($token, 'image'),
 $form->textAreaControlGroup($token, 'descrition', array('span' => '6', 'rows' => 3));

$buttons = array(TbHtml::submitButton('Submit', array('color' => TbHtml::BUTTON_COLOR_SUCCESS)));
if (!$token->isNewRecord) {
    $buttons[] = TbHtml::linkButton('Add New', array('url' => array('new'), 'color' => TbHtml::BUTTON_COLOR_INFO));
}
$buttons[] = TbHtml::linkButton('Cancel', array('url' => array('index')));

echo TbHtml::formActions($buttons);

$this->endWidget();
