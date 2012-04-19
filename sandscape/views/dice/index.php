<?php $this->title = 'Dice'; ?>
<h2>Manage Dice</h2>

<a href="<?php echo $this->createURL('create'); ?>">Create Dice</a>
<?php
$this->widget('zii.widgets.grid.CGridView', array(
    'id' => 'dice-grid',
    'dataProvider' => $filter->search(),
    'filter' => $filter,
    'columns' => array(
        array(
            'name' => 'name',
            'type' => 'html',
            'value' => 'CHtml::link($data->name, Yii::app()->createUrl("dice/update", array("id" => $data->diceId)))'
        ),
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