<?php

/** @var DiceController $this */
$this->title = Yii::t('sandsacpe', 'New Die');

echo $this->renderPartial('_form', array('dice' => $dice));
