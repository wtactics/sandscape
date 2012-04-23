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

<?php echo $this->renderPartial('_form', array('deck' => $deck, 'cards' => $cards)); ?>

<p>
    <a href="<?php echo $this->createUrl('decks/export', array('id' => $deck->deckId, 'type' => 'txt')); ?>">
        <img src="_resources/images/icon-x16-document-text.png" title="Export as Text" />
    </a>
    <a href="<?php echo $this->createUrl('decks/export', array('id' => $deck->deckId, 'type' => 'html')); ?>">
        <img src="_resources/images/icon-x16-html.png" title="Export as HTML" />
    </a>
    <a href="<?php echo $this->createUrl('decks/export', array('id' => $deck->deckId, 'type' => 'pdf')); ?>">
        <img src="_resources/images/icon-x16-document-pdf.png" title="Export as PDF" />
    </a>
</p>