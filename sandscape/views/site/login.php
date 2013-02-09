<?php
$this->title = Yii::t('interface', 'Login or Register');
?>
<div class="container">        
    <div class="span5">
        <h2 class="page-header"><?php echo Yii::t('interface', 'Login'); ?></h2>
        <?php $this->renderPartial('_login', array('login' => $login)); ?>
    </div>

    <div class="span6">
        <h2 class="page-header"><?php echo Yii::t('interface', 'Register new account'); ?></h2>
        <?php $this->renderPartial('_register', array('register' => $register)); ?>
    </div>
</div>
