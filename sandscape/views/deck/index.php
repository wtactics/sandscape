<?php
$this->breadcrumbs=array(
	'Decks',
);

$this->menu=array(
	array('label'=>'Create Deck', 'url'=>array('create')),
	array('label'=>'Manage Deck', 'url'=>array('admin')),
);
?>

<h1>Decks</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
