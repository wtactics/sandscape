<?php
Yii::app()->clientScript->registerCssFile('_resources/css/deck.css');
Yii::app()->clientScript->registerCoreScript('jquery.ui');
Yii::app()->clientScript->registerScriptFile('_resources/js/deck.js', CClientScript::POS_END);
?>
<h2><?php echo ($deck->isNewRecord ? 'Create Deck' : 'Edit Deck'); ?></h2>   
<?php echo $this->renderPartial('_form', array('deck' => $deck, 'cards' => $cards)); ?>