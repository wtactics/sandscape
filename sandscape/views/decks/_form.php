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
    <ul id="selected-cards">
        <?php
        $items = array();
        $total = 0;
        foreach ($deck->deckCards as $dc) {
            if (!isset($items[$dc->cardId])) {
                $items[$dc->cardId]['name'] = $dc->card->name;
                $items[$dc->cardId]['count'] = 1;
            } else {
                $items[$dc->cardId]['count'] += 1;
            }
            $total += 1;
        }

        foreach ($items as $key => $item) {
            ?>
            <li id="c<?php echo $key; ?>">
                <?php echo $item['name']; ?>
                <span class="card-count"><?php echo $item['count']; ?></span>
            </li>
        <?php } ?>
    </ul>
    <p>Total cards in deck: <?php echo $total; ?></p>
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
    <ul id="available-cards">
        <?php foreach ($cards as $card) { ?>
            <li class="available" id="a<?php echo $card->cardId; ?>"><?php echo $card->name; ?></li>
        <?php } ?>
    </ul>
</div>
<div class="span-7 last centered">
    <h3>Preview</h3>
    <!-- //TODO: remove the fixed width -->
    <img src="_game/cards/cardback.jpg" width="250px" id="previewImage" />
</div>
<?php
$this->endWidget();