<?php

/** @var $this TokensController */
$this->widget('bootstrap.widgets.TbDetailView', array(
    'data' => $token,
    'attributes' => array(
        'tokenId',
        'name'
    ),
));

$this->widget('bootstrap.widgets.TbButton', array(
    'url' => $this->createUrl('tokens/update', array('id' => $token->tokenId)),
    'label' => Yii::t('sandscape', 'Edit'),
    'type' => 'info'
));