<?php
/** @var $this UsersController */
$this->title = Yii::t('sandscape', 'New User');
?>

<h2><?php echo Yii::t('sandscape', 'New User'); ?></h2>

<?php
$this->renderPartial('_form', array('user' => $user));
