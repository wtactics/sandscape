<?php
$this->breadcrumbs=array(
	'Cards'=>array('index'),
	$model->cardId=>array('view','id'=>$model->cardId),
	'Update',
);

$this->menu=array(
	array('label'=>'List Card', 'url'=>array('index')),
	array('label'=>'Create Card', 'url'=>array('create')),
	array('label'=>'View Card', 'url'=>array('view', 'id'=>$model->cardId)),
	array('label'=>'Manage Card', 'url'=>array('admin')),
);
?>

<h1>Update Card <?php echo $model->cardId; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>