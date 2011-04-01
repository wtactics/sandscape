<?php
$this->breadcrumbs=array(
	'Wins'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Win', 'url'=>array('index')),
	array('label'=>'Manage Win', 'url'=>array('admin')),
);
?>

<h1>Create Win</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>