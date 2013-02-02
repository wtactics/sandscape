<?php

/** @var DiceController $this */
$this->title = Yii::t('sandsacpe', 'Edit Die');

echo $this->renderPartial('_form', array('dice' => $dice));
