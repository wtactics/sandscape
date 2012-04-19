<?php $this->title = 'Cards'; ?>
<h2>Card List</h2>
<a href="<?php echo $this->createURL('create'); ?>">Create Card</a>
<a href="<?php echo $this->createURL('import'); ?>">CSV Import</a>
<?php
$this->widget('zii.widgets.grid.CGridView', array(
    'id' => 'card-grid',
    'dataProvider' => $filter->search(),
    'filter' => $filter,
    'columns' => array(
        array(
            'name' => 'name',
            'type' => 'html',
            'value' => 'CHtml::link($data->name, Yii::app()->createUrl("cards/update", array("id" => $data->cardId)))'
        ),
        array(
            'header' => 'Actions',
            'class' => 'CButtonColumn',
        )
    ),
    'template' => '{items} {pager} {summary}'
));