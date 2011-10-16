<?php
$this->menu = array(
    array('label' => 'List Game', 'url' => array('index')),
    array('label' => 'Manage Game', 'url' => array('admin')),
);
?>

<h1>Create Game</h1>

<?php echo $this->renderPartial('_form', array('model' => $model)); ?>