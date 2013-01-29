<?php
$this->title = ($user->isNewRecord ? 'Create User' : 'Edit User');

if (YII_DEBUG) {
    Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/css/development/forms.css');
}
?>
<h2><?php echo ($user->isNewRecord ? 'Create User' : 'Edit User'); ?></h2>
<?php
echo $this->renderPartial('_form', array('user' => $user));