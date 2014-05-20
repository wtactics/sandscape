<?php
/** @var $this TokensController */
$this->title = Yii::t('sandscape', 'Tokens');
?>
<h2><?php echo Yii::t('sandscape', 'Tokens'); ?></h2>

<?php
$this->widget('bootstrap.widgets.TbGridView', array(
    'id' => 'token-grid',
    'dataProvider' => $filter->search(),
    'filter' => $filter,
    'type' => TbHtml::GRID_TYPE_STRIPED . ', ' . TbHtml::GRID_TYPE_BORDERED,
    'columns' => array(
        array(
            'name' => 'name',
            'type' => 'html',
            'value' => 'CHtml::link($data->name, Yii::app()->createUrl("tokens/edit", array("id" => $data->id)))'
        ),
    ),
));
