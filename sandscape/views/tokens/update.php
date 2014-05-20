<?php

/** @var TokensController $this */
$this->title = Yii::t('Sandscape', 'Edit Token');

echo $this->renderPartial('_form', array('token' => $token));
