<?php
$this->title = Yii::t('sandscape', 'Cards');
?>

<h2><?php echo Yii::t('sandscape', 'Card List'); ?></h2>

<?php
$this->widget('bootstrap.widgets.TbGridView', array(
    'id' => 'card-grid',
    'dataProvider' => $filter->search(),
    'filter' => $filter,
    'template' => '{items} {pager} {summary}',
    'type' => 'striped condensed bordered',
    'columns' => array(
        array(
            'name' => 'name',
            'type' => 'html',
            'value' => 'CHtml::link($data->name, Yii::app()->createUrl("cards/update", array("id" => $data->cardId)))'
        ),
        array(
            'header' => Yii::t('sandscape', 'Actions'),
            'class' => 'bootstrap.widgets.TbButtonColumn',
            'htmlOptions' => array('style' => 'width: 50px')
        )
    ),
));

$this->widget('bootstrap.widgets.TbButton', array(
    'label' => Yii::t('sandsacpe', 'New Card'),
    'type' => 'info',
    'url' => $this->createUrl('cards/create'),
));

//TODO: not implemented yet
//$this->widget('bootstrap.widgets.TbButton', array(
//    'label' => Yii::t('sandsacpe', 'CSV Import'),
//    'type' => 'info',
//    'url' => $this->createUrl('cards/import'),
//));
