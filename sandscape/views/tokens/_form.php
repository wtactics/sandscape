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

<legend><?php echo Yii::t('interface', 'Token Details'); ?></legend>

<?php
echo $form->textFieldRow($token, 'name', array('maxlength' => 150, 'class' => 'span6')),
 $form->fileFieldRow($token, 'image'),
 $form->textAreaRow($token, 'descrition', array('class' => 'span6', 'rows' => 3));

$this->widget('bootstrap.widgets.TbButton', array(
    'buttonType' => 'submit',
    'label' => Yii::t('interface', 'Save'),
    'type' => 'success'
));

$this->widget('bootstrap.widgets.TbButton', array(
    'url' => $this->createUrl('tokens/index'),
    'label' => Yii::t('interface', 'Cancel'),
    'type' => 'warning'
));

$this->endWidget();