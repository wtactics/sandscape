<?php $this->title = 'Users'; ?>
<h2>User List</h2>
<div class="span-2 prepend-20 last"><a href="<?php echo $this->createURL('create'); ?>">New User</a></div>
<?php
$this->widget('zii.widgets.grid.CGridView', array(
    'id' => 'user-grid',
    'dataProvider' => $filter->search(),
    'filter' => $filter,
    'columns' => array(
        'name',
        array(
            'name' => 'email',
            'type' => 'email'
        ),
        //TODO: image icon instead of number
        array(
            'name' => 'admin',
            'filter' => array(0 => 'Regular', 1 => 'Administrator'),
        ),
        array(
            'header' => 'Actions',
            'class' => 'CButtonColumn',
            'buttons' => array(
                'view' => array('visible' => 'false'),
            )
        )
    )
));
?>