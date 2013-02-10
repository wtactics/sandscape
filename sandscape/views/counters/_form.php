<?php
/** @var BootActiveForm $form */
/** @var CountersController $this */
$form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
    'id' => 'playercounter-form',
    'type' => 'horizontal',
    'enableAjaxValidation' => true,
    'focus' => array($counter, 'name'),
        ));
?>

<legend><?php echo Yii::t('interface', 'Player Counter Details'); ?></legend>


<?php
echo $form->textFieldRow($counter, 'name', array('maxlength' => 150)),
 $form->textFieldRow($counter, 'startValue'),
 $form->textFieldRow($counter, 'step'),
 $form->checkBoxRow($counter, 'enabled');

$this->widget('bootstrap.widgets.TbButton', array(
    'buttonType' => 'submit',
    'label' => Yii::t('interface', 'Save'),
    'type' => 'success'
));

$this->widget('bootstrap.widgets.TbButton', array(
    'url' => $this->createUrl('counters/index'),
    'label' => Yii::t('interface', 'Cancel'),
    'type' => 'warning'
));

$this->endWidget();