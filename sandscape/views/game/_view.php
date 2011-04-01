<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('gameId')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->gameId), array('view', 'id'=>$data->gameId)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('playerA')); ?>:</b>
	<?php echo CHtml::encode($data->playerA); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('playerB')); ?>:</b>
	<?php echo CHtml::encode($data->playerB); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('created')); ?>:</b>
	<?php echo CHtml::encode($data->created); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('started')); ?>:</b>
	<?php echo CHtml::encode($data->started); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('ended')); ?>:</b>
	<?php echo CHtml::encode($data->ended); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('running')); ?>:</b>
	<?php echo CHtml::encode($data->running); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('deckA')); ?>:</b>
	<?php echo CHtml::encode($data->deckA); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('deckB')); ?>:</b>
	<?php echo CHtml::encode($data->deckB); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('hash')); ?>:</b>
	<?php echo CHtml::encode($data->hash); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('chatId')); ?>:</b>
	<?php echo CHtml::encode($data->chatId); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('private')); ?>:</b>
	<?php echo CHtml::encode($data->private); ?>
	<br />

	*/ ?>

</div>