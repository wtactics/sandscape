<?php

/** @var CountersController $this */
$this->title = Yii::t('sandscape', 'Edit Counter');

echo $this->renderPartial('_form', array('counter' => $counter));
