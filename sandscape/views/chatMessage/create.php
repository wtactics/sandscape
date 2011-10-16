<?php
$this->menu=array(
	array('label'=>'List ChatMessage', 'url'=>array('index')),
	array('label'=>'Manage ChatMessage', 'url'=>array('admin')),
);
?>

<h1>Create ChatMessage</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>