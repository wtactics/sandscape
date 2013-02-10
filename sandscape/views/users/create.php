<?php
/** @var $this UsersController */
$this->title = Yii::t('interface', 'New User');

$this->renderPartial('_form', array('user' => $user));