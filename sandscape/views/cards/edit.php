<?php
$this->title = ($card->isNewRecord ? 'Create Card' : 'Edit Card');
Yii::app()->clientScript->registerCssFile('_resources/css/sandscape/forms.css');
?>
<h2><?php echo ($card->isNewRecord ? 'Create Card' : 'Edit Card'); ?></h2>
<?php echo $this->renderPartial('_form', array('card' => $card)); ?>