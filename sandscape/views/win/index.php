<?php
$this->breadcrumbs=array(
	'Wins',
);

$this->menu=array(
	array('label'=>'Create Win', 'url'=>array('create')),
	array('label'=>'Manage Win', 'url'=>array('admin')),
);
?>

<h1>Wins</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
