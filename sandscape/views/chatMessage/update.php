<?php
$this->menu=array(
	array('label'=>'List ChatMessage', 'url'=>array('index')),
	array('label'=>'Create ChatMessage', 'url'=>array('create')),
	array('label'=>'View ChatMessage', 'url'=>array('view', 'id'=>$model->messageId)),
	array('label'=>'Manage ChatMessage', 'url'=>array('admin')),
);
?>

<h1>Update ChatMessage <?php echo $model->messageId; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>