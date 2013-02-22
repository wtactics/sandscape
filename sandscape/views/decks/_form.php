<?php
/** @var BootActiveForm $form */
/** @var DecksController $this */
$form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
    'id' => 'deck-form',
    'type' => 'horizontal',
    'enableAjaxValidation' => true,
    'focus' => array($deck, 'name'),
        ));
?>

<legend><?php echo Yii::t('interface', 'Deck Details'); ?></legend>

<?php
echo $form->textFieldRow($deck, 'name', array('maxlength' => 255, 'class' => 'span6')),
 $form->fileFieldRow($deck, 'back');

$this->widget('bootstrap.widgets.TbButton', array(
    'buttonType' => 'submit',
    'label' => Yii::t('interface', 'Save'),
    'type' => 'success'
));

$this->widget('bootstrap.widgets.TbButton', array(
    'url' => $this->createUrl('decks/index'),
    'label' => Yii::t('interface', 'Cancel'),
    'type' => 'warning'
));

$this->endWidget();
?>

<div>
    <div class="span5">
        Available Cards
        <div>
            <div>
                <span></span>
                <input type="number" value="1" />
                <span></span>
            </div>
        </div>
    </div>

    <div class="span5">
        Cards in Deck
        <ul>
            <li>
                <span></span>
                <span></span>
                <span></span>
            </li>
        </ul>
    </div>
</div>