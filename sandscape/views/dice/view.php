<?php

/** @var $this DiceController */
$this->widget('bootstrap.widgets.TbDetailView', array(
    'data' => $dice,
    'attributes' => array(
        'id',
        'name',
        'face',
        array(
            'name' => 'enabled',
            'value' => $dice->isEnabledString()
        ),
    ),
));

$this->widget('bootstrap.widgets.TbButton', array(
    'url' => $this->createUrl('dice/update', array('id' => $dice->id)),
    'label' => Yii::t('interface', 'Edit'),
    'type' => 'info'
));
