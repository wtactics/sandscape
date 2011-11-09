<?php
Yii::app()->clientScript->registerCssFile('_resources/css/sandscape/forms.css');

$this->title = ($state->isNewRecord ? 'Create State' : 'Edit State');
?>
<h2><?php echo ($state->isNewRecord ? 'Create State' : 'Edit State'); ?></h2>   

<?php
echo $this->renderPartial('_form', array('state' => $state));