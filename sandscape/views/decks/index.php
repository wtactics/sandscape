<?php
/** @var $this DecksController */
$this->title = Yii::t('interface', 'Decks');
?>

<h2><?php echo Yii::t('interface', 'Deck List'); ?></h2>

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
            'value' => 'CHtml::link($data->name, Yii::app()->createUrl("decks/update", array("id" => $data->id)))'
        ),
        'createdOn',
        array(
            'header' => Yii::t('interface', 'Actions'),
            'class' => 'bootstrap.widgets.TbButtonColumn',
            'htmlOptions' => array('style' => 'width: 50px'),
        )
    )
));

$this->widget('bootstrap.widgets.TbButton', array(
    'label' => Yii::t('interface', 'New Deck'),
    'type' => 'info',
    'size' => 'small',
    'url' => $this->createURL('decks/create')
));
