<?php
$this->title = Yii::t('sandscape', 'Cards');
?>

<h2><?php echo Yii::t('sandscape', 'Card List'); ?></h2>

<?php
$this->widget('bootstrap.widgets.TbGridView', array(
    'id' => 'card-grid',
    'dataProvider' => $filter->search(),
    'filter' => $filter,
    'columns' => array(
        array(
            'name' => 'name',
            'type' => 'html',
            'value' => 'CHtml::link($data->name, Yii::app()->createUrl("cards/edit", array("id" => $data->id)))'
        )
    ),
));
