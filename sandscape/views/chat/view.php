<?php
$this->breadcrumbs=array(
	'Chats'=>array('index'),
	$model->chatId,
);

$this->menu=array(
	array('label'=>'List Chat', 'url'=>array('index')),
	array('label'=>'Create Chat', 'url'=>array('create')),
	array('label'=>'Update Chat', 'url'=>array('update', 'id'=>$model->chatId)),
	array('label'=>'Delete Chat', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->chatId),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Chat', 'url'=>array('admin')),
);
?>

<h1>View Chat #<?php echo $model->chatId; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'chatId',
		'started',
	),
)); ?>
