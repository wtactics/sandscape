<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('messageId')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->messageId), array('view', 'id'=>$data->messageId)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('message')); ?>:</b>
	<?php echo CHtml::encode($data->message); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('sent')); ?>:</b>
	<?php echo CHtml::encode($data->sent); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('userId')); ?>:</b>
	<?php echo CHtml::encode($data->userId); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('gameId')); ?>:</b>
	<?php echo CHtml::encode($data->gameId); ?>
	<br />


</div>