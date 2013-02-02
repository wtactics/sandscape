<?php
/** @var $this TokensController */
$this->title = Yii::t('sandsacep', 'Game Tokens');
?>
<h2><?php echo Yii::t('sandsacep', 'Game Tokens'); ?></h2>

<?php
$this->widget('bootstrap.widgets.TbGridView', array(
    'id' => 'token-grid',
    'dataProvider' => $filter->search(),
    'filter' => $filter,
    'template' => '{items} {pager} {summary}',
    'type' => 'striped condensed bordered',
    'columns' => array(
        array(
            'name' => 'name',
            'type' => 'html',
            'value' => 'CHtml::link($data->name, Yii::app()->createUrl("tokens/update", array("id" => $data->tokenId)))'
        ),
        array(
            'header' => Yii::t('sandscape', 'Actions'),
            'class' => 'bootstrap.widgets.TbButtonColumn',
            'htmlOptions' => array('style' => 'width: 50px'),
        )
    ),
));

$this->widget('bootstrap.widgets.TbButton', array(
    'label' => Yii::t('sandscape', 'New Token'),
    'type' => 'info',
    'size' => 'small',
    'url' => $this->createURL('tokens/create')
));
