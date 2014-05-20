<?php

/** @var CardsController $this */
$form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
    'id' => 'user-form',
    'layout' => TbHtml::FORM_LAYOUT_HORIZONTAL,
    'enableAjaxValidation' => true,
    'htmlOptions' => array('enctype' => 'multipart/form-data')
        ));

echo $form->textFieldControlGroup($card, 'name', array('maxlength' => 255, 'class' => 'span8')),
 $form->textAreaControlGroup($card, 'rules', array('class' => 'span8', 'rows' => 5)),
 $form->fileFieldControlGroup($card, 'face'),
 $form->fileFieldControlGroup($card, 'back'),
 $form->dropDownListControlGroup($card, 'backFrom', Card::backOriginsArray()),
 $form->textFieldControlGroup($card, 'cardscapeId', array('class' => 'input-small'));

echo TbHtml::formActions(array(
    TbHtml::submitButton('Submit', array('color' => TbHtml::BUTTON_COLOR_PRIMARY)),
    TbHtml::button('Cancel')
));

$this->endWidget();
