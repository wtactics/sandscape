<?php

/** @var CardsController $this */
/** @var $form TbActiveForm */
$form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
    'id' => 'user-form',
    'layout' => TbHtml::FORM_LAYOUT_HORIZONTAL,
    'enableAjaxValidation' => true,
    'htmlOptions' => array('enctype' => 'multipart/form-data')
        ));

echo $form->textFieldControlGroup($card, 'name', array('maxlength' => 255, 'class' => 'span8')),
 $form->textAreaControlGroup($card, 'rules', array('span' => '8', 'rows' => 5)),
 $form->fileFieldControlGroup($card, 'face'),
 $form->fileFieldControlGroup($card, 'back'),
 $form->dropDownListControlGroup($card, 'backFrom', Card::backOriginsArray()),
 $form->textFieldControlGroup($card, 'cardscapeRevisionId', array('class' => 'input-small'));

$buttons = array(TbHtml::submitButton('Submit', array('color' => TbHtml::BUTTON_COLOR_SUCCESS)));
if (!$card->isNewRecord) {
    $buttons[] = TbHtml::linkButton('Add New', array('url' => array('new'), 'color' => TbHtml::BUTTON_COLOR_INFO));
}
$buttons[] = TbHtml::linkButton('Cancel', array('url' => array('index')));

echo TbHtml::formActions($buttons);

$this->endWidget();
