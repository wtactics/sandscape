<?php

/** @var $this UsersController */
/** @var $form TbActiveForm */
$form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
    'id' => 'user-form',
    'layout' => TbHtml::FORM_LAYOUT_HORIZONTAL,
    'enableAjaxValidation' => true
        ));

echo $form->textFieldControlGroup($user, 'name', array('maxlength' => 150)),
 $form->textFieldControlGroup($user, 'email', array('maxlength' => 255)),
 $form->dropDownListControlGroup($user, 'role', User::rolesArray()),
 $form->textFieldControlGroup($user, 'website', array('maxlength' => 255)),
 $form->textFieldControlGroup($user, 'twitter', array('maxlength' => 255)),
 $form->textFieldControlGroup($user, 'facebook', array('maxlength' => 255)),
 $form->textFieldControlGroup($user, 'googleplus', array('maxlength' => 255)),
 $form->textFieldControlGroup($user, 'skype', array('maxlength' => 255));

echo $form->checkBoxControlGroup($user, 'showChatTimes'),
 $form->checkBoxControlGroup($user, 'reverseCards'),
 $form->checkBoxControlGroup($user, 'onHoverDetails');

$buttons = array(TbHtml::submitButton('Submit', array('color' => TbHtml::BUTTON_COLOR_SUCCESS)));
if (!$user->isNewRecord) {
    $buttons[] = TbHtml::linkButton('Add New', array('url' => array('new'), 'color' => TbHtml::BUTTON_COLOR_INFO));
}
$buttons[] = TbHtml::linkButton('Cancel', array('url' => array('index')));

echo TbHtml::formActions($buttons);

$this->endWidget();
