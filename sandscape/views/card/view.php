<div class="span-13">
    <div class="span-4 border">
        <strong><?php echo CHtml::encode($card->getAttributeLabel('cardId')); ?>:</strong>
        <br />
        <strong><?php echo CHtml::encode($card->getAttributeLabel('name')); ?>:</strong>
        <br />
        <strong><?php echo CHtml::encode($card->getAttributeLabel('cardscapeId')); ?>:</strong>
        <br />
        <strong><?php echo CHtml::encode($card->getAttributeLabel('rules')); ?>:</strong>
    </div>
    <div class="span-9 last">
        <?php echo CHtml::link(CHtml::encode($card->cardId), array('view', 'id' => $card->cardId)); ?>
        <br />
        <?php echo CHtml::encode($card->name); ?>
        <br />
        <?php echo CHtml::encode($card->cardscapeId); ?>
        <br />
        <?php echo CHtml::encode($card->rules); ?>
    </div>
</div>
<div class="span-9 last">
    <strong><?php echo CHtml::encode($card->getAttributeLabel('image')); ?>:</strong>
    <br />
    <?php echo CHtml::image('_cards/up/' . $card->image); ?>
</div>