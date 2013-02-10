<?php

/** @var CounterController $this */
$this->title = Yii::t('interface', 'New Player Counter');

echo $this->renderPartial('_form', array('counter' => $counter));
