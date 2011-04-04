<?php
$this->widget('zii.widgets.CMenu', array(
    'id' => 'submenu',
    'items' => $menu,
));
?>

<div class="clear"></div>

<h1>Cards</h1>

<?php
$this->widget('zii.widgets.CListView', array(
    'dataProvider' => $dataProvider,
    'itemView' => '_view',
));
?>
