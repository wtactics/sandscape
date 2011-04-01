<?php
$this->breadcrumbs=array(
	'Wins'=>array('index'),
	$model->userId=>array('view','id'=>$model->userId),
	'Update',
);

$this->menu=array(
	array('label'=>'List Win', 'url'=>array('index')),
	array('label'=>'Create Win', 'url'=>array('create')),
	array('label'=>'View Win', 'url'=>array('view', 'id'=>$model->userId)),
	array('label'=>'Manage Win', 'url'=>array('admin')),
);
?>

<h1>Update Win <?php echo $model->userId; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>