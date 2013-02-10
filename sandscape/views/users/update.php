<?php

/** @var $this UsersController */
$this->title = Yii::t('interface', 'Edit User');

$this->renderPartial('_form', array('user' => $user));