<?php

/** @var $this DiceController */
$this->widget('bootstrap.widgets.TbDetailView', array(
    'data' => $dice,
    'attributes' => array(
        'diceId',
        'name',
        'face',
        array(
            'name' => 'enabled',
            'value' => $dice->getEnabled()
        ),
    ),
));

$this->widget('bootstrap.widgets.TbButton', array(
    'url' => $this->createUrl('dice/update', array('id' => $dice->diceId)),
    'label' => Yii::t('sandscape', 'Edit'),
    'type' => 'info'
));
