<?php

/** @var DiceController $this */
$this->title = Yii::t('sandscape', 'Edit Die');

echo $this->renderPartial('_form', array('dice' => $dice));
