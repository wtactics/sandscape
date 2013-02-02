<?php
/** @var AccountsController $this */
$this->title = Yii::t('sandscape', 'Profile');

/** @var BootActiveForm $form */
$form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
    'id' => 'user-form',
    'type' => 'horizontal',
    'enableAjaxValidation' => true,
        ));
?>

<legend><?php echo Yii::t('sandscape', 'Public Information'); ?></legend>

<?php
echo $form->textFieldRow($user, 'name', array('maxlength' => 150)),
 $form->textFieldRow($user, 'email', array('maxlength' => 255)),
 $form->textFieldRow($user, 'website', array('maxlength' => 255)),
 $form->textFieldRow($user, 'twitter', array('maxlength' => 255)),
 $form->textFieldRow($user, 'facebook', array('maxlength' => 255)),
 $form->textFieldRow($user, 'googleplus', array('maxlength' => 255)),
 $form->textFieldRow($user, 'skype', array('maxlength' => 255)),
 $form->dropDownListRow($user, 'country', array_merge(array('' => ''), User::countries()));
?>

<legend><?php echo Yii::t('sandscape', 'Iterface Options'); ?></legend>

<?php
echo $form->checkboxRow($user, 'showChatTimes'),
 $form->checkboxRow($user, 'reverseCards'),
 $form->checkboxRow($user, 'onHoverDetails');

$this->widget('bootstrap.widgets.TbButton', array(
    'buttonType' => 'submit',
    'label' => Yii::t('sandscape', 'Save'),
    'type' => 'success'
));

$this->widget('bootstrap.widgets.TbButton', array(
    'url' => $this->createUrl('dashboard/index'),
    'label' => Yii::t('sandscape', 'Cancel'),
    'type' => 'warning'
));

$this->endWidget();