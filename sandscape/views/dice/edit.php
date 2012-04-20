<?php 

$this->title = ($dice->isNewRecord ? 'Create Dice' : 'Edit Dice'); 

Yii::app()->clientScript->registerCssFile('_resources/css/sandscape/forms' . (YII_DEBUG ? '' : '.min') . '.css');
?>

<h2><?php echo ($dice->isNewRecord ? 'Create Dice' : 'Edit Dice'); ?></h2>   

<?php
echo $this->renderPartial('_form', array('dice' => $dice));
