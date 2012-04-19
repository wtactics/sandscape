<?php $this->title = 'States'; ?>
<h2>Manage States</h2>
<a href="<?php echo $this->createURL('create'); ?>">Create State</a>

<?php
$this->widget('zii.widgets.grid.CGridView', array(
    'id' => 'state-grid',
    'dataProvider' => $filter->search(),
    'filter' => $filter,
    'columns' => array(
        array(
            'name' => 'name',
            'type' => 'html',
            'value' => 'CHtml::link($data->name, Yii::app()->createUrl("states/update", array("id" => $data->stateId)))'
        ),
        array(
            'header' => 'Actions',
            'class' => 'CButtonColumn',
            'buttons' => array(
                'view' => array('visible' => 'false')
            )
        )
    ),
    'template' => '{items} {pager} {summary}'
));