<?php
$this->widget('zii.widgets.CMenu', array(
    'id' => 'submenu',
    'items' => $menu,
));
?>

<div class="clear"></div>

<h1>Logs</h1>

<?php //$this->widget('zii.widgets.grid.CGridView', $logGrid); ?>

<h1>Running Chats</h1>

<?php //$this->widget('zii.widgets.grid.CGridView', $chatGrid); ?>

<h1>Orphan Images</h1>

<?php $this->widget('zii.widgets.grid.CGridView', $imageGrid); ?>