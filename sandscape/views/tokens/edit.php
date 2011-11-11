<?php
Yii::app()->clientScript->registerCssFile('_resources/css/sandscape/forms' . (YII_DEBUG ? '' : '.min') . '.css');

$this->title = ($token->isNewRecord ? 'Create Token' : 'Edit Token');
?>
<h2><?php echo ($token->isNewRecord ? 'Create Token' : 'Edit Token'); ?></h2>   

<?php
echo $this->renderPartial('_form', array('token' => $token));