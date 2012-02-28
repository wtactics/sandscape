<?php
$this->title = 'Login';
Yii::app()->clientScript->registerCssFile('_resources/css/sandscape/forms' . (YII_DEBUG ? '' : '.min') . '.css');
?>
<h2>Login</h2>

<div class="span-11">
    <?php $this->renderPartial('_register', array('register' => $register)); ?>
</div>

<div class="span-10 prepend-1 last">
    <?php $this->renderPartial('_login', array('login' => $login)); ?>
    <p><a href="<?php echo $this->createURL('site/recoverpassword'); ?>">Forgot your password?</a></p>
</div>