<?php $this->title = 'Users'; ?>
<h2>User List</h2>
<div class="span-22 last"><a href="<?php echo $this->createURL('create'); ?>">Create User</a></div>
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
        array(
            'name' => 'admin',
            'filter' => array(0 => 'Regular', 1 => 'Administrator'),
            'type' => 'raw',
            'value' => '($data->admin ? "Administrator" : "Regular")'
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