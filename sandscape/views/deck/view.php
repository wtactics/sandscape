<?php
$this->menu = array(
    array('label' => 'List Deck', 'url' => array('index')),
    array('label' => 'Create Deck', 'url' => array('create')),
    array('label' => 'Update Deck', 'url' => array('update', 'id' => $model->deckId)),
    array('label' => 'Delete Deck', 'url' => '#', 'linkOptions' => array('submit' => array('delete', 'id' => $model->deckId), 'confirm' => 'Are you sure you want to delete this item?')),
    array('label' => 'Manage Deck', 'url' => array('admin')),
);
?>

<h1>View Deck #<?php echo $model->deckId; ?></h1>

<?php
$this->widget('zii.widgets.CDetailView', array(
    'data' => $model,
    'attributes' => array(
        'deckId',
        'name',
        'userId',
        'created',
        'active',
    ),
));
?>
