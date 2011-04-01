<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('chatId')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->chatId), array('view', 'id'=>$data->chatId)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('started')); ?>:</b>
	<?php echo CHtml::encode($data->started); ?>
	<br />


</div>