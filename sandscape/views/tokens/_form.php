<?php

/** @var $this TokensController */
$form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
    'id' => 'user-form',
    'layout' => TbHtml::FORM_LAYOUT_HORIZONTAL,
    'enableAjaxValidation' => true,
    'htmlOptions' => array('enctype' => 'multipart/form-data')
        ));

echo $form->textFieldControlGroup($token, 'name', array('maxlength' => 150, 'class' => 'span6')),
 $form->fileFieldControlGroup($token, 'image'),
 $form->textAreaControlGroup($token, 'descrition', array('span' => '6', 'rows' => 3));

echo TbHtml::formActions(array(
    TbHtml::submitButton('Submit', array('color' => TbHtml::BUTTON_COLOR_PRIMARY)),
    TbHtml::button('Cancel')
));

$this->endWidget();
