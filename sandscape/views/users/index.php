<?php
$this->widget('zii.widgets.CMenu', array(
    'id' => 'submenu',
    'items' => $menu,
));
?>

<div class="clear"></div>

<h1>Manage Users</h1>

<?php
$this->widget('zii.widgets.grid.CGridView', array(
    'dataProvider' => $model->search(),
    //'filter' => $model,
    'columns' => array(
        'name',
        'email',
        array(
            'name' => 'visited',
            'value' => 'date("Y/m/d - H:m", $data->visited)',
            ),
        'admin',
        array(
            'class' => 'CButtonColumn',
        ),
    ),
));
?>
