<?php $this->title = 'Dice'; ?>
<h2>Manage Dice</h2>

<div class="span-22 last">
    <a href="<?php echo $this->createURL('create'); ?>">Create Dice</a>
</div>
<?php
$this->widget('zii.widgets.grid.CGridView', array(
    'id' => 'dice-grid',
    'dataProvider' => $filter->search(),
    'filter' => $filter,
    'columns' => array(
        'name',
        'face',
        array(
            'name' => 'enabled',
            'filter' => array(0 => 'No', 1 => 'Yes'),
            'type' => 'raw',
            'value' => '($data->enabled ? \'<span class="yes">Yes</span>\' : \'<span class="no">No</span>\')'
        ),
        array(
            'header' => 'Actions',
            'class' => 'CButtonColumn',
            'buttons' => array(
                'view' => array('visible' => 'false'),
            )
        ),
    ),
    'template' => '{items} {pager} {summary}'
));