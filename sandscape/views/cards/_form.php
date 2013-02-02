<?php
/** @var BootActiveForm $form */
/** @var CardsController $this */
$form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
    'id' => 'card-form',
    'type' => 'horizontal',
    'enableAjaxValidation' => true,
    'focus' => array($card, 'name'),
        ));
?>

<legend><?php echo Yii::t('sandscape', 'Card Details'); ?></legend>


<?php
echo $form->textFieldRow($card, 'name', array('maxlength' => 150)),
 $form->textFieldRow($card, 'cardscapeId'),
 $form->textAreaRow($card, 'rules');

$this->widget('bootstrap.widgets.TbButton', array(
    'buttonType' => 'submit',
    'label' => Yii::t('sandscape', 'Save'),
    'type' => 'success'
));

$this->widget('bootstrap.widgets.TbButton', array(
    'url' => $this->createUrl('cards/index'),
    'label' => Yii::t('sandscape', 'Cancel'),
    'type' => 'warning'
));

$this->endWidget();