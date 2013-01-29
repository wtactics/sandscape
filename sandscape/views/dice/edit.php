<?php
$this->title = ($dice->isNewRecord ? 'Create Dice' : 'Edit Dice');
if (YII_DEBUG) {
    Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/css/development/forms.css');
}
?>

<h2><?php echo ($dice->isNewRecord ? 'Create Dice' : 'Edit Dice'); ?></h2>   

<?php
echo $this->renderPartial('_form', array('dice' => $dice));
