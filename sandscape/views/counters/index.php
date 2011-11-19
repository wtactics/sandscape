<?php $this->title = 'Player Counters'; ?>
<h2>Manage Player Counters</h2>
<div class="span-22 last">
    <a href="<?php echo $this->createURL('create'); ?>">Create Counter</a>
</div>
<?php
$this->widget('zii.widgets.grid.CGridView', array(
    'id' => 'counter-grid',
    'dataProvider' => $filter->search(),
    'filter' => $filter,
    'columns' => array(
        'name',
        'startValue',
        'step',
        array(
            'name' => 'available',
            'filter' => array(0 => 'No', 1 => 'Yes'),
            'type' => 'raw',
            'value' => '($data->available ? \'<span class="yes">Yes</span>\' : \'<span class="no">No</span>\')'
        ),
        array(
            'header' => 'Actions',
            'class' => 'CButtonColumn',
            'buttons' => array(
                'view' => array('visible' => 'false'),
            )
        ),
    ),
));