<?php

$this->widget('zii.widgets.grid.CGridView', array(
    'id' => 'user-grid',
    'dataProvider' => $filter->search(),
    'filter' => $filter,
    'columns' => array(
        'email',
        'name',
        'admin',
        array(
            'class' => 'CButtonColumn',
        ),
    ),
));
?>
