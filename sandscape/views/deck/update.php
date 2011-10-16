<?php
$this->menu = array(
    array('label' => 'List Deck', 'url' => array('index')),
    array('label' => 'Create Deck', 'url' => array('create')),
    array('label' => 'View Deck', 'url' => array('view', 'id' => $model->deckId)),
    array('label' => 'Manage Deck', 'url' => array('admin')),
);
?>

<h1>Update Deck <?php echo $model->deckId; ?></h1>

<?php echo $this->renderPartial('_form', array('model' => $model)); ?>