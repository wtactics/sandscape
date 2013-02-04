<?php
$this->title = Yii::t('sandscape', 'Login or Register');
?>
<div class="span6">
    <?php $this->renderPartial('_login', array('login' => $login)); ?>
</div>

<div class="span6">
    <?php $this->renderPartial('_register', array('register' => $register)); ?>
</div>
