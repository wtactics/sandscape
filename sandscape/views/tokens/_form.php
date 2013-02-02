<?php
/** @var BootActiveForm $form */
/** @var TokensController $this */
$form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
    'id' => 'token-form',
    'type' => 'horizontal',
    'enableAjaxValidation' => true,
    'focus' => array($token, 'name'),
        ));
?>

<legend><?php echo Yii::t('sandscape', 'Token Details'); ?></legend>

<?php
echo $form->textFieldRow($token, 'name', array('maxlength' => 150));

$this->widget('bootstrap.widgets.TbButton', array(
    'buttonType' => 'submit',
    'label' => Yii::t('sandscape', 'Save'),
    'type' => 'success'
));

$this->widget('bootstrap.widgets.TbButton', array(
    'url' => $this->createUrl('tokens/index'),
    'label' => Yii::t('sandscape', 'Cancel'),
    'type' => 'warning'
));

$this->endWidget();