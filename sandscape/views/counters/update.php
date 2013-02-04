<?php

/** @var CounterController $this */
$this->title = Yii::t('sandscape', 'Edit Player Counter');

echo $this->renderPartial('_form', array('counter' => $counter));
