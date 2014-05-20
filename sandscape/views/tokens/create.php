<?php

/** @var TokensController $this */
$this->title = Yii::t('sandscape', 'New Token');

echo $this->renderPartial('_form', array('token' => $token));
