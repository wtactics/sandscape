<?php
$this->title = ($counter->isNewRecord ? 'Create Player Counter' : 'Edit Player Counter');

Yii::app()->clientScript->registerCssFile('_resources/css/sandscape/forms' . (YII_DEBUG ? '' : '.min') . '.css');
?>

<h2><?php echo ($counter->isNewRecord ? 'Create Player Counter' : 'Edit Player Counter'); ?></h2>   

<?php
echo $this->renderPartial('_form', array('counter' => $counter));
