<?php

/** @var DiceController $this */
$this->title = Yii::t('sandscape', 'New Die');

echo $this->renderPartial('_form', array('dice' => $dice));
