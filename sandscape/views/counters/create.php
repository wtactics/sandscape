<?php

/** @var CountersController $this */
$this->title = Yii::t('sandscape', 'New Counter');

echo $this->renderPartial('_form', array('counter' => $counter));
