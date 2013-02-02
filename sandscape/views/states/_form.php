<?php
/** @var BootActiveForm $form */
/** @var StatesController $this */
$form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
    'id' => 'state-form',
    'type' => 'horizontal',
    'enableAjaxValidation' => true,
    'focus' => array($state, 'name'),
        ));
?>

<legend><?php echo Yii::t('sandscape', 'State Details'); ?></legend>


<?php
echo $form->textFieldRow($user, 'name', array('maxlength' => 150));

$this->widget('bootstrap.widgets.TbButton', array(
    'buttonType' => 'submit',
    'label' => Yii::t('sandscape', 'Save'),
    'type' => 'success'
));

$this->widget('bootstrap.widgets.TbButton', array(
    'url' => $this->createUrl('users/index'),
    'label' => Yii::t('sandscape', 'Cancel'),
    'type' => 'warning'
));

$this->endWidget();
