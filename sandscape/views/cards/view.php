<?php
/* $this->menu=array(
  array('label'=>'List Card', 'url'=>array('index')),
  array('label'=>'Create Card', 'url'=>array('create')),
  array('label'=>'Update Card', 'url'=>array('update', 'id'=>$model->cardId)),
  array('label'=>'Delete Card', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->cardId),'confirm'=>'Are you sure you want to delete this item?')),
  array('label'=>'Manage Card', 'url'=>array('admin')),
  ); */
?>

<h1>View Card #<?php echo $model->cardId; ?></h1>

<?php
$this->widget('zii.widgets.CDetailView', array(
    'data' => $model,
    'attributes' => array(
        'cardId',
        'faction',
        'type',
        'subtype',
        'cost',
        'threshold',
        'attack',
        'defense',
        'rules',
        'author',
        'revision',
        'cardscapeId',
        'imageId',
        'private',
        'active',
    ),
));
?>
