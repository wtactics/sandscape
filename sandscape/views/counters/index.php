<?php $this->title = 'Player Counters'; ?>
<h2>Player Counters</h2>

<div class="list-tools">
    <a href="<?php echo $this->createURL('create'); ?>">Create Counter</a>
</div>
<?php
$this->widget('bootstrap.widgets.TbGridView', array(
    'id' => 'user-grid',
    'dataProvider' => $filter->search(),
    'filter' => $filter,
    'template' => '{items} {pager} {summary}',
    'type' => 'striped condensed bordered',
    'columns' => array(

$this->widget('zii.widgets.grid.CGridView', array(
    'id' => 'counter-grid',
    'dataProvider' => $filter->search(),
    'filter' => $filter,
    'cssFile' => false,
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
            'filter' => array(0 => 'No', 1 => 'Yes'),
            'type' => 'raw',
            'value' => '($data->available ? \'<span class="yes">Yes</span>\' : \'<span class="no">No</span>\')'
        ),
        array(
            'header' => Yii::t('sandscape', 'Actions'),
            'class' => 'bootstrap.widgets.TbButtonColumn',
            'htmlOptions' => array('style' => 'width: 50px'),
        )
    ),
    'template' => '{items} {pager} {summary}'
));
    
    $this->widget('bootstrap.widgets.TbButton', array(
    'label' => Yii::t('sandscape', 'New User'),
    'type' => 'info',
    'size' => 'small',
    'url' => $this->createURL('users/create')
));