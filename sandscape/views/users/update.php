<?php
/** @var $this UsersController */
$this->title = Yii::t('sandscape', 'Edit User');
?>

<h2>Edit User</h2>

<?php
$this->renderPartial('_form', array('user' => $user));
