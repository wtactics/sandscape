<?php
/** @var $this UsersController */
$this->title = Yii::t('sandscape', 'New User');

$this->renderPartial('_form', array('user' => $user));