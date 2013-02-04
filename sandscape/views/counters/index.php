<?php $this->title = Yii::t('sandscape', 'Player Counters'); ?>
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
            'value' => 'CHtml::link($data->name, Yii::app()->createUrl("counters/update", array("id" => $data->playerCounterId)))'
        ),
        'startValue',
        'step',
        array(
            'name' => 'available',
            'filter' => array(0 => Yii::t('sandscape', 'No'), 1 => Yii::t('sandscape', 'Yes')),
            'type' => 'raw',
            'value' => '$data->getAvailable()'
        ),
        array(
            'header' => Yii::t('sandscape', 'Actions'),
            'class' => 'bootstrap.widgets.TbButtonColumn',
            'htmlOptions' => array('style' => 'width: 50px'),
        )
    ),
));

$this->widget('bootstrap.widgets.TbButton', array(
    'label' => Yii::t('sandscape', 'New Counter'),
    'type' => 'info',
    'size' => 'small',
    'url' => $this->createURL('counters/create')
));