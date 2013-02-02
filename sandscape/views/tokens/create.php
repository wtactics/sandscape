<?php

/** @var TokensController $this */
$this->title = Yii::t('sandsacpe', 'New Token');

echo $this->renderPartial('_form', array('token' => $token));
