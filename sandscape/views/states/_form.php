<?php

/** @var StatesController $this */
$form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
    'id' => 'user-form',
    'layout' => TbHtml::FORM_LAYOUT_HORIZONTAL,
    'enableAjaxValidation' => true,
    'htmlOptions' => array('enctype' => 'multipart/form-data')
        ));

echo $form->textFieldControlGroup($state, 'name', array('maxlength' => 150, 'class' => 'span6')),
 $form->fileFieldControlGroup($state, 'image'),
 $form->textAreaControlGroup($state, 'description', array('span' => '6', 'rows' => 3));

echo TbHtml::formActions(array(
    TbHtml::submitButton('Submit', array('color' => TbHtml::BUTTON_COLOR_PRIMARY)),
    TbHtml::button('Cancel')
));

$this->endWidget();
