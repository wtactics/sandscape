<?php
Yii::app()->clientScript->registerCoreScript('jquery.ui');

Yii::app()->clientScript->registerCssFile('_resources/css/sandscape/deck.css');
Yii::app()->clientScript->registerScriptFile('_resources/js/sandscape/deck.js', CClientScript::POS_END);

$this->title = ($deck->isNewRecord ? 'Create Deck' : 'Edit Deck');
?>
<h2><?php echo ($deck->isNewRecord ? 'Create Deck' : 'Edit Deck'); ?></h2>   
<?php echo $this->renderPartial('_form', array('deck' => $deck, 'cards' => $cards)); ?>