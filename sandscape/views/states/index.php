<?php $this->title = 'Card In-game States'; ?>
<h2>Card In-game States</h2>

<div class="list-tools">
    <a href="<?php echo $this->createURL('create'); ?>">Create State</a>
</div>

<?php
$this->widget('zii.widgets.grid.CGridView', array(
    'id' => 'state-grid',
    'dataProvider' => $filter->search(),
    'filter' => $filter,
    'cssFile' => false,
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