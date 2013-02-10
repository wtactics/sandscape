<?php

/** @var $this CountersController */
$this->widget('bootstrap.widgets.TbDetailView', array(
    'data' => $counter,
    'attributes' => array(
        'id',
        'name',
        'startValue',
        'step',
        array(
            'name' => 'enabled',
            'value' => $counter->isEnabledString()
        )
    ),
));

$this->widget('bootstrap.widgets.TbButton', array(
    'url' => $this->createUrl('counters/update', array('id' => $counter->id)),
    'label' => Yii::t('interface', 'Edit'),
    'type' => 'info'
));