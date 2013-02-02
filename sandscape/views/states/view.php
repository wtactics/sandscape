<?php

/** @var $this StatesController */
$this->widget('bootstrap.widgets.TbDetailView', array(
    'data' => $state,
    'attributes' => array(
        'stateId',
        'name',
    ),
));

$this->widget('bootstrap.widgets.TbButton', array(
    'url' => $this->createUrl('states/update', array('id' => $state->stateId)),
    'label' => Yii::t('sandscape', 'Edit'),
    'type' => 'info'
));