<?php $this->title = 'Card details for "' . CHtml::encode($card->name) . '"'; ?>
<h2>View Card</h2>

<strong><?php echo CHtml::encode($card->getAttributeLabel('cardId')); ?>:</strong>
<strong><?php echo CHtml::encode($card->getAttributeLabel('name')); ?>:</strong>
<strong><?php echo CHtml::encode($card->getAttributeLabel('rules')); ?>:</strong>

<?php echo $card->cardId; ?>
<?php echo CHtml::encode($card->name); ?>
<?php echo CHtml::encode($card->rules); ?>

<?php if ($card->cardscapeId) { ?>
    <p style="padding-top: 1em;">
        <?php echo CHtml::link('See card details at Cardscape', $cardscapeUrl . '?act=show_card&id=' . $card->cardscapeId, array('target' => '_blanck'));
        ?>
    </p>
<?php } ?>

<strong><?php echo CHtml::encode($card->getAttributeLabel('image')); ?>:</strong>
<?php echo CHtml::image('_game/cards/' . $card->image); ?>

<?php echo CHtml::link('Return', $this->createUrl('/cards')); ?>