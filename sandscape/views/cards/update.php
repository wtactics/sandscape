<?php

/** @var CardsController $this */
$this->title = Yii::t('sandscape', 'Edit Card');

echo $this->renderPartial('_form', array('card' => $card));
