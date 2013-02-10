<?php

/** @var DiceController $this */
$this->title = Yii::t('interface', 'Edit Die');

echo $this->renderPartial('_form', array('dice' => $dice));
