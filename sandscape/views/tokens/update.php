<?php

/** @var TokensController $this */
$this->title = Yii::t('interface', 'Edit Token');

echo $this->renderPartial('_form', array('token' => $token));
