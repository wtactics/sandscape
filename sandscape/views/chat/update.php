<?php
$this->breadcrumbs=array(
	'Chats'=>array('index'),
	$model->chatId=>array('view','id'=>$model->chatId),
	'Update',
);

$this->menu=array(
	array('label'=>'List Chat', 'url'=>array('index')),
	array('label'=>'Create Chat', 'url'=>array('create')),
	array('label'=>'View Chat', 'url'=>array('view', 'id'=>$model->chatId)),
	array('label'=>'Manage Chat', 'url'=>array('admin')),
);
?>

<h1>Update Chat <?php echo $model->chatId; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>