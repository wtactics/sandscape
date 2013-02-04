<?php

/** @var $this CountersController */
$this->widget('bootstrap.widgets.TbDetailView', array(
    'data' => $counter,
    'attributes' => array(
        'playerCounterId',
        'name',
        'startValue',
        'step',
        array(
            'name' => 'available',
            'value' => $counter->getAvailable()
        )
    ),
));

$this->widget('bootstrap.widgets.TbButton', array(
    'url' => $this->createUrl('counters/update', array('id' => $counter->playerCounterId)),
    'label' => Yii::t('sandscape', 'Edit'),
    'type' => 'info'
));