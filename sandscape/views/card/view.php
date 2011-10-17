<?php echo CHtml::encode($card->getAttributeLabel('cardId')); ?>:
<?php echo CHtml::link(CHtml::encode($card->cardId), array('view', 'id' => $card->cardId)); ?>
<br />

<?php echo CHtml::encode($card->getAttributeLabel('name')); ?>:
<?php echo CHtml::encode($card->name); ?>
<br />

<?php echo CHtml::encode($card->getAttributeLabel('rules')); ?>:
<?php echo CHtml::encode($card->rules); ?>
<br />

<?php echo CHtml::encode($card->getAttributeLabel('image')); ?>:
<?php echo CHtml::encode($card->image); ?>
<br />

<?php echo CHtml::encode($card->getAttributeLabel('cardscapeId')); ?>:
<?php echo CHtml::encode($card->cardscapeId); ?>
<br />

<?php echo CHtml::encode($card->getAttributeLabel('active')); ?>:
<?php echo CHtml::encode($card->active); ?>
<br />