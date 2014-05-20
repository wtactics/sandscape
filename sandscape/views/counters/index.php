<?php
/** @var $this CounterController */
$this->title = Yii::t('sandscape', 'Player Counters');
?>

<h2><?php echo Yii::t('sandscape', 'Player Counters'); ?></h2>

<?php
$this->widget('bootstrap.widgets.TbGridView', array(
    'id' => 'user-grid',
    'dataProvider' => $filter->search(),
    'filter' => $filter,
    'template' => '{items} {pager} {summary}',
    'type' => 'striped condensed bordered',
    'columns' => array(
        array(
            'name' => 'name',
            'type' => 'html',
            'value' => 'CHtml::link($data->name, Yii::app()->createUrl("counters/edit", array("id" => $data->id)))'
        ),
        'startValue',
        'step',
    ),
));
