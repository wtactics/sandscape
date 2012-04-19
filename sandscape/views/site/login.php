<?php
$this->title = 'Login';
Yii::app()->clientScript->registerCssFile('_resources/css/sandscape/forms' . (YII_DEBUG ? '' : '.min') . '.css');
?>
<h2>Login</h2>


<?php $this->renderPartial('_register', array('register' => $register)); ?>


<?php $this->renderPartial('_login', array('login' => $login)); ?>
<p><a href="<?php echo $this->createURL('site/recoverpassword'); ?>">Forgot your password?</a></p>
