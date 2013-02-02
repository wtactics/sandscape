<?php

/** @var $this UsersController */
$this->title = Yii::t('sandscape', 'Edit User');

$this->renderPartial('_form', array('user' => $user));