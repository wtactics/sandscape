<?php
$this->breadcrumbs=array(
	'Chats',
);

$this->menu=array(
	array('label'=>'Create Chat', 'url'=>array('create')),
	array('label'=>'Manage Chat', 'url'=>array('admin')),
);
?>

<h1>Chats</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
