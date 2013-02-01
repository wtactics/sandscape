<?php
$this->title = Yii::t('sandscape', 'New User');
?>

<?php
$this->renderPartial('_form', array('user' => $user));