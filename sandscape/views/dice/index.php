<?php
/** @var $this UsersController */
$this->title = Yii::t('sandscape', 'Dice List');
?>
<h2><?php echo Yii::t('sandscape', 'Dice List') ?></h2>

<?php
$this->widget('bootstrap.widgets.TbGridView', array(
    'id' => 'dice-grid',
    'dataProvider' => $filter->search(),
    'filter' => $filter,
    'template' => '{items} {pager} {summary}',
    'type' => 'striped condensed bordered',
    'columns' => array(
        array(
            'name' => 'name',
            'type' => 'html',
            'value' => 'CHtml::link($data->name, Yii::app()->createUrl("dice/update", array("id" => $data->id)))'
        ),
        'face',
        array(
            'name' => 'enabled',
            'filter' => array(0 => Yii::t('sandscape', 'No'), 1 => Yii::t('sandscape', 'Yes')),
            'type' => 'raw',
            'value' => '$data->isEnabledString()'
        ),
        array(
            'header' => Yii::t('interface', 'Actions'),
            'class' => 'bootstrap.widgets.TbButtonColumn',
            'htmlOptions' => array('style' => 'width: 50px'),
        )
    ),
));

$this->widget('bootstrap.widgets.TbButton', array(
    'label' => Yii::t('interface', 'New Die'),
    'type' => 'info',
    'size' => 'small',
    'url' => $this->createURL('dice/create')
));