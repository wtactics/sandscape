<?php
/** @var $this UsersController */
$this->title = Yii::t('sandscape', 'Account');
?>

<h2><?php echo Yii::t('sandscape', 'Account'); ?></h2>

<?php
$form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
    'id' => 'user-form',
    'layout' => TbHtml::FORM_LAYOUT_HORIZONTAL,
    'enableAjaxValidation' => true,
        ));

echo $form->textFieldControlGroup($user, 'name', array('maxlength' => 150)),
 $form->textFieldControlGroup($user, 'email', array('maxlength' => 255)),
 $form->textFieldControlGroup($user, 'website', array('maxlength' => 255)),
 $form->textFieldControlGroup($user, 'twitter', array('maxlength' => 255)),
 $form->textFieldControlGroup($user, 'facebook', array('maxlength' => 255)),
 $form->textFieldControlGroup($user, 'googleplus', array('maxlength' => 255)),
 $form->textFieldControlGroup($user, 'skype', array('maxlength' => 255));

echo $form->checkBoxControlGroup($user, 'showChatTimes'),
 $form->checkBoxControlGroup($user, 'reverseCards'),
 $form->checkBoxControlGroup($user, 'onHoverDetails');


echo TbHtml::formActions(array(
    TbHtml::submitButton('Submit', array('color' => TbHtml::BUTTON_COLOR_PRIMARY)),
    TbHtml::resetButton('Reset'),
));

$this->endWidget();
