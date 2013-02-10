<?php
/** @var BootActiveForm $form */
/** @var CardsController $this */
$form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
    'id' => 'card-form',
    'type' => 'horizontal',
    'enableAjaxValidation' => true,
    'focus' => array($card, 'name'),
    'htmlOptions' => array('enctype' => 'multipart/form-data')
        ));
?>

<legend><?php echo Yii::t('sandscape', 'Card Details'); ?></legend>


<?php
echo $form->textFieldRow($card, 'name', array('maxlength' => 255, 'class' => 'span8')),
 $form->textAreaRow($card, 'rules', array('class' => 'span8', 'rows' => 5)),
 $form->fileFieldRow($card, 'face'),
 $form->fileFieldRow($card, 'back'),
 $form->dropDownListRow($card, 'backFrom', Card::backOriginsArray()),
 $form->textFieldRow($card, 'cardscapeId', array('class' => 'input-small'));

$this->widget('bootstrap.widgets.TbButton', array(
    'buttonType' => 'submit',
    'label' => Yii::t('interface', 'Save'),
    'type' => 'success'
));

$this->widget('bootstrap.widgets.TbButton', array(
    'url' => $this->createUrl('cards/index'),
    'label' => Yii::t('interface', 'Cancel'),
    'type' => 'warning'
));

$this->endWidget();
