<?php
$form = $this->beginWidget('CActiveForm', array('id' => 'deck-form'));
?>

<fieldset>
    <legend>Deck information</legend>
    <p>
        <?php
        echo $form->labelEx($deck, 'name'), '<br />',
        $form->textField($deck, 'name', array('size' => 60, 'maxlength' => 100, 'class' => 'text'));
        ?>
    </p>
    <?php echo $form->error($deck, 'name'); ?>
</fieldset>
<p>
    <?php echo CHtml::submitButton($deck->isNewRecord ? 'Create' : 'Save', array('class' => 'button')); ?>

    <?php if (!$deck->isNewRecord && Yii::app()->user->class) { ?>
        &nbsp;&nbsp;&nbsp;
        <?php echo CHtml::link('Make Template', $this->createURL('deck/maketemplate', array('id' => $deck->deckId))); ?>
    <?php } ?>
</p>

<div class="span-7">
    <h3>Cards in Deck</h3>
    <input type="text" class="textsmaller" />
    <ul>

    </ul>
</div>
<div class="span-1">
    <!-- <p><button type="button" class="button">&lt;</button></p>
    <p><button type="button" class="button">&lt;</button></p>
    <p><button type="button" class="button">&lt;</button></p>
    <p><button type="button" class="button">&lt;</button></p> -->
    &nbsp;
</div>
<div class="span-7">
    <h3>Available Cards</h3>
    <input type="text" class="textsmaller" />
    <?php
    $items = array();
    foreach ($cards as $card) {
        $items[$card->cardId] = $card->name;
    }
    //$this->widget('zii.widgets.jui.CJuiSelectable', array(
    //    'items' => $items,
    //    'tagName' => 'ul'
    //));
    ?>
</div>
<div class="span-7 last centered">
    <h3>Preview</h3>
    <img src="_game/cards/cardback.jpg" width="250px"/>
</div>
<?php $this->endWidget(); ?>