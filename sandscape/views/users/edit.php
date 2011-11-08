<?php
$this->title = ($user->isNewRecord ? 'Create User' : 'Edit User');
Yii::app()->clientScript->registerCssFile('_resources/css/sandscape/forms.css');
?>
<h2><?php echo ($user->isNewRecord ? 'Create User' : 'Edit User'); ?></h2>
<?php echo $this->renderPartial('_form', array('user' => $user)); ?></div>