<?php $this->title = Yii::t('sandscape', 'Card States'); ?>
<h2><?php echo Yii::t('sandscape', 'Card States'); ?></h2>

<?php
$this->widget('bootstrap.widgets.TbGridView', array(
    'id' => 'user-grid',
    'dataProvider' => $filter->search(),
    'filter' => $filter,
    'columns' => array(
        array(
            'name' => 'name',
            'type' => 'html',
            'value' => 'CHtml::link($data->name, Yii::app()->createUrl("states/edit", array("id" => $data->id)))'
        )
    ),
));
