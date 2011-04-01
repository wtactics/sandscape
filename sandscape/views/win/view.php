<?php
$this->breadcrumbs=array(
	'Wins'=>array('index'),
	$model->userId,
);

$this->menu=array(
	array('label'=>'List Win', 'url'=>array('index')),
	array('label'=>'Create Win', 'url'=>array('create')),
	array('label'=>'Update Win', 'url'=>array('update', 'id'=>$model->userId)),
	array('label'=>'Delete Win', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->userId),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Win', 'url'=>array('admin')),
);
?>

<h1>View Win #<?php echo $model->userId; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'userId',
		'gameId',
	),
)); ?>
