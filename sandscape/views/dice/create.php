<?php

/** @var DiceController $this */
$this->title = Yii::t('interface', 'New Die');

echo $this->renderPartial('_form', array('dice' => $dice));
