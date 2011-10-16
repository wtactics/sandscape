<?php
$this->menu=array(
	array('label'=>'List ChatMessage', 'url'=>array('index')),
	array('label'=>'Create ChatMessage', 'url'=>array('create')),
	array('label'=>'Update ChatMessage', 'url'=>array('update', 'id'=>$model->messageId)),
	array('label'=>'Delete ChatMessage', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->messageId),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage ChatMessage', 'url'=>array('admin')),
);
?>

<h1>View ChatMessage #<?php echo $model->messageId; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'messageId',
		'message',
		'sent',
		'userId',
		'gameId',
	),
)); ?>
