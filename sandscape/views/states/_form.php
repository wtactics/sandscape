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

<legend><?php echo Yii::t('interface', 'State Details'); ?></legend>

<?php
echo $form->textFieldRow($state, 'name', array('maxlength' => 150, 'class' => 'span6')),
 $form->fileFieldRow($state, 'image'),
 $form->textAreaRow($state, 'description', array('class' => 'span6', 'rows' => 3));

$this->widget('bootstrap.widgets.TbButton', array(
    'buttonType' => 'submit',
    'label' => Yii::t('interface', 'Save'),
    'type' => 'success'
));

$this->widget('bootstrap.widgets.TbButton', array(
    'url' => $this->createUrl('states/index'),
    'label' => Yii::t('interface', 'Cancel'),
    'type' => 'warning'
));

$this->endWidget();
