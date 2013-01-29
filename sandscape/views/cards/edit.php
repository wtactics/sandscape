<?php
$this->title = ($card->isNewRecord ? 'Create Card' : 'Edit Card');

if (YII_DEBUG) {
    Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/css/development/forms.css');
}
?>

<h2><?php echo ($card->isNewRecord ? 'Create Card' : 'Edit Card'); ?></h2>

<?php
echo $this->renderPartial('_form', array('card' => $card));