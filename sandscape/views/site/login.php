<?php
$this->title = 'Login or Register';

if (YII_DEBUG) {
Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/css/development/forms.css');
}
?>
<h2>Login or Register</h2>

<div class="halfleft">
    <?php $this->renderPartial('_login', array('login' => $login)); ?>

    <p><a href="<?php echo $this->createURL('site/recoverpassword'); ?>">Forgot your password?</a></p>
</div>

<div class="halfright">
    <?php $this->renderPartial('_register', array('register' => $register)); ?>
</div>



