<?php $this->title = 'Card details for "' . CHtml::encode($card->name) . '"'; ?>
<h2>View Card</h2>
<div class="span-13">
    <div class="span-4 border">
        <strong><?php echo CHtml::encode($card->getAttributeLabel('cardId')); ?>:</strong>
        <br />
        <strong><?php echo CHtml::encode($card->getAttributeLabel('name')); ?>:</strong>
        <br />
        <strong><?php echo CHtml::encode($card->getAttributeLabel('rules')); ?>:</strong>
    </div>
    <div class="span-9 last">
        <?php echo $card->cardId; ?>
        <br />
        <?php echo CHtml::encode($card->name); ?>
        <br />
        <?php echo CHtml::encode($card->rules); ?>
    </div>
    <div class="span-13 last">
        <?php if ($card->cardscapeId) { ?>
            <p style="padding-top: 1em;">
                <?php echo CHtml::link('See card details at Cardscape', 'http://chaosrealm.net/wtactics/cardscape/index.php?act=show_card&id=' . $card->cardscapeId, array('target' => '_blanck'));
                ?>
            </p>
        <?php } ?>
    </div>
</div>
<div class="span-8 prepend-1 last">
    <strong><?php echo CHtml::encode($card->getAttributeLabel('image')); ?>:</strong>
    <br />
    <?php echo CHtml::image('_cards/up/' . $card->image); ?>
</div>