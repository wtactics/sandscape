<?php
/** @var BootActiveForm $form */
/** @var DiceController $this */
$form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
    'id' => 'dice-form',
    'type' => 'horizontal',
    'enableAjaxValidation' => true,
    'focus' => array($dice, 'name'),
        ));
?>

<legend><?php echo Yii::t('sandscape', 'Die Details'); ?></legend>

<?php
echo $form->textFieldRow($dice, 'name', array('maxlength' => 150)),
 $form->textFieldRow($dice, 'face'),
 $form->checkBoxRow($dice, 'enabled');

$this->widget('bootstrap.widgets.TbButton', array(
    'buttonType' => 'submit',
    'label' => Yii::t('sandscape', 'Save'),
    'type' => 'success'
));

$this->widget('bootstrap.widgets.TbButton', array(
    'url' => $this->createUrl('dice/index'),
    'label' => Yii::t('sandscape', 'Cancel'),
    'type' => 'warning'
));

$this->endWidget();