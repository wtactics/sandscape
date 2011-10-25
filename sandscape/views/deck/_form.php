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

<div class="span-11 append-1">
    <h3>Cards in deck</h3>
    <div id="usecards">
        <?php
        $i = 0;
        foreach ($deck->deckCards as $dkc) {
            $card = $dkc->card;
            $top = 0;
            $left = 0;

            if ($i > 0) {
                $top = ((int) ($i / 14)) * 40;
                $left = ($i - (14 * ((int) ($i / 14)))) * 25;
            }
            ?>
            <img class="chosen s-card-<?php echo $card->cardId; ?>" style="left: <?php echo $left; ?>px; top: <?php echo $top; ?>px; " src="_cards/up/thumbs/<?php echo $card->image; ?>" id="s-card-<?php echo $card->cardId, $i; ?>">
            <input class="hs-card-<?php echo $card->cardId; ?>" type="hidden" name="using[]" value="card-<?php echo $card->cardId; ?>" id="hs-card-<?php echo $card->cardId, $i; ?>" />
            <?php
            $i++;
        }
        ?>
    </div>
</div>
<div class="span-10 last">
    <h3><?php echo count($cards); ?> Existing cards</h3>
    <div id="existingcards">
        <?php foreach ($cards as $card) { ?>
            <img class="available" src="_cards/up/thumbs/<?php echo $card->image; ?>" title="<?php echo $card->name; ?>" id="card-<?php echo $card->cardId; ?>" />
        <?php } ?>
    </div>


</div>
<?php $this->endWidget(); ?>