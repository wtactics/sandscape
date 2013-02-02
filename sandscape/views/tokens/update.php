<?php

/** @var TokensController $this */
$this->title = Yii::t('sandsacpe', 'Edit Token');

echo $this->renderPartial('_form', array('token' => $token));
