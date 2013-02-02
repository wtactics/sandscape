<?php

/** @var $this CardsController */
$this->widget('bootstrap.widgets.TbDetailView', array(
    'data' => $card,
    'attributes' => array(
        'cardId',
        'name',
        array(
            'name' => 'cardscapeId',
            'value' => $card->cardscapeId ? $card->cardscapeId : '-'
        ),
        'rules',
    ),
));

$this->widget('bootstrap.widgets.TbButton', array(
    'url' => $this->createUrl('cards/update', array('id' => $card->cardId)),
    'label' => Yii::t('sandscape', 'Edit'),
    'type' => 'info'
));