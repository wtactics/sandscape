<?php
if (YII_DEBUG) {
    Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/css/development/forms.css');
}

$this->title = ($token->isNewRecord ? 'Create Token' : 'Edit Token');
?>
<h2><?php echo ($token->isNewRecord ? 'Create Token' : 'Edit Token'); ?></h2>   

<?php
echo $this->renderPartial('_form', array('token' => $token));