<?php

$this->title = Yii::t('sandscape', 'Edit User');
?>

<?php

$this->renderPartial('_form', array('user' => $user));