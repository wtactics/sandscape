<?php
if (YII_DEBUG) {
    Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/css/development/forms.css');
}

$this->title = ($state->isNewRecord ? 'Create State' : 'Edit State');
?>
<h2><?php echo ($state->isNewRecord ? 'Create State' : 'Edit State'); ?></h2>   

<?php
echo $this->renderPartial('_form', array('state' => $state));