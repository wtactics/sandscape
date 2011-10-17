<?php
$this->menu=array(
	array('label'=>'List Deck', 'url'=>array('index')),
	array('label'=>'Manage Deck', 'url'=>array('admin')),
);
?>

<h1>Create Deck</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>