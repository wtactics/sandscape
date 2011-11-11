<?php
Yii::app()->clientScript->registerCoreScript('jquery.ui');

Yii::app()->clientScript->registerCssFile('_resources/css/sandscape/forms' . (YII_DEBUG ? '' : '.min') . '.css');
Yii::app()->clientScript->registerCssFile('_resources/css/sandscape/deck' . (YII_DEBUG ? '' : '.min') . '.css');
Yii::app()->clientScript->registerScriptFile('_resources/js/sandscape/deck' . (YII_DEBUG ? '' : '.min') . '.js', CClientScript::POS_HEAD);

$url = $this->createUrl('decks/imagepreview');
Yii::app()->clientScript->registerScript('init', "init('{$url}');");

$this->title = ($deck->isNewRecord ? 'Create Deck' : 'Edit Deck');
?>
<h2><?php echo ($deck->isNewRecord ? 'Create Deck' : 'Edit Deck'); ?></h2>   

<?php
echo $this->renderPartial('_form', array('deck' => $deck, 'cards' => $cards));