<?php
$this->widget('zii.widgets.CMenu', array(
    'id' => 'submenu',
    'items' => $menu,
));
?>

<div class="clear"></div>

<h1>Manage Pages</h1>

<?php
$this->widget('zii.widgets.grid.CGridView', array(
    'id' => 'page-grid',
    'dataProvider' => $dataProvider,
    'columns' => array(
        'pageId',
        'title',
        'updated',
        'active',
        array(
            'class' => 'CButtonColumn',
        ),
    ),
));
