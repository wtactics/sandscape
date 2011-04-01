<?php
$this->breadcrumbs=array(
	'Games'=>array('index'),
	$model->gameId=>array('view','id'=>$model->gameId),
	'Update',
);

$this->menu=array(
	array('label'=>'List Game', 'url'=>array('index')),
	array('label'=>'Create Game', 'url'=>array('create')),
	array('label'=>'View Game', 'url'=>array('view', 'id'=>$model->gameId)),
	array('label'=>'Manage Game', 'url'=>array('admin')),
);
?>

<h1>Update Game <?php echo $model->gameId; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>