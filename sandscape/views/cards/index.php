<?php $this->title = 'Card List'; ?>
<h2>Card List</h2>
<div class="list-tools">
    <a href="<?php echo $this->createURL('create'); ?>">Create Card</a>
    <a href="<?php echo $this->createURL('import'); ?>">CSV Import</a>
</div>
<?php
$this->widget('zii.widgets.grid.CGridView', array(
    'id' => 'card-grid',
    'dataProvider' => $filter->search(),
    'filter' => $filter,
    'cssFile' => false,
    'columns' => array(
        array(
            'name' => 'name',
            'type' => 'html',
            'value' => 'CHtml::link($data->name, Yii::app()->createUrl("cards/update", array("id" => $data->cardId)))'
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