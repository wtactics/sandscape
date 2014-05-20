<?php

/** @var DecksController $this */
$form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
    'id' => 'user-form',
    'layout' => TbHtml::FORM_LAYOUT_HORIZONTAL,
    'enableAjaxValidation' => true,
    'htmlOptions' => array('enctype' => 'multipart/form-data')
        ));

echo $form->textFieldControlGroup($deck, 'name', array('maxlength' => 255, 'class' => 'span6')),
 $form->fileFieldControlGroup($deck, 'back');

echo TbHtml::formActions(array(
    TbHtml::submitButton('Submit', array('color' => TbHtml::BUTTON_COLOR_PRIMARY)),
    TbHtml::button('Cancel')
));

$this->endWidget();
