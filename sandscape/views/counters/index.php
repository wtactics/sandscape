<?php
/** @var CountersController $this */
$this->title = Yii::t('sandscape', 'Counters');
?>

<h2><?php echo Yii::t('sandscape', 'Counters'); ?></h2>

<?php
$this->widget('bootstrap.widgets.TbGridView', array(
    'id' => 'user-grid',
    'dataProvider' => $filter->search(),
    'filter' => $filter,
    'type' => TbHtml::GRID_TYPE_STRIPED . ', ' . TbHtml::GRID_TYPE_BORDERED,
    'columns' => array(
        array(
            'name' => 'name',
            'type' => 'html',
            'value' => 'CHtml::link($data->name, Yii::app()->createUrl("counters/edit", array("id" => $data->id)))'
        )
    )
));
