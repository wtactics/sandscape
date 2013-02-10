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

<legend><?php echo Yii::t('interface', 'Die Details'); ?></legend>

<?php
echo $form->textFieldRow($dice, 'name', array('maxlength' => 150, 'class' => 'span6')),
 $form->textFieldRow($dice, 'face', array('class' => 'input-small')),
 $form->checkBoxRow($dice, 'enabled'),
 $form->textAreaRow($dice, 'description', array('class' => 'span6', 'rows' => 3));

$this->widget('bootstrap.widgets.TbButton', array(
    'buttonType' => 'submit',
    'label' => Yii::t('interface', 'Save'),
    'type' => 'success'
));

$this->widget('bootstrap.widgets.TbButton', array(
    'url' => $this->createUrl('dice/index'),
    'label' => Yii::t('interface', 'Cancel'),
    'type' => 'warning'
));

$this->endWidget();
