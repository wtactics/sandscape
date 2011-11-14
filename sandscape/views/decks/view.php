<?php
Yii::app()->clientScript->registerCoreScript('jquery.ui');

Yii::app()->clientScript->registerCssFile('_resources/css/sandscape/deck.view' . (YII_DEBUG ? '' : '.min') . '.css');
Yii::app()->clientScript->registerCssFile('_resources/css/sandscape/forms' . (YII_DEBUG ? '' : '.min') . '.css');

Yii::app()->clientScript->registerScriptFile('_resources/js/sandscape/deck.view' . (YII_DEBUG ? '' : '.min') . '.js');

$url = $this->createUrl('decks/imagepreview');
Yii::app()->clientScript->registerScript('init', "init('{$url}');");

$total = 0;
$items = array();
foreach ($deck->deckCards as $dc) {
    if (!isset($items[$dc->cardId])) {
        $items[$dc->cardId]['name'] = $dc->card->name;
        $items[$dc->cardId]['count'] = 1;
    } else {
        $items[$dc->cardId]['count'] += 1;
    }
    $total += 1;
}
?>
<h2><?php echo $deck->name; ?></h2>
<div class="span-10 append-1">
    <h3>Cards in Deck</h3>
    <input type="text" class="textsmaller" id="filterSelected" placeholder="filter cards in deck..." />
    <ul id="cards">
        <?php foreach ($items as $key => $item) { ?>
            <li id="c<?php echo $key; ?>">
                <?php echo $item['name']; ?>
                <span class="card-count"><?php echo $item['count']; ?></span>
            </li>
        <?php } ?>
    </ul>
    <p>Total cards in deck: <span id="card-total"><?php echo $total; ?></span></p>
    <p>
        <a href="<?php echo $this->createUrl('decks/export', array('id' => $deck->deckId, 'type' => 'txt')); ?>"><img src="_resources/images/icon-x16-document-text.png" title="Export as Text" /></a>
        &nbsp;&nbsp;
        <a href="<?php echo $this->createUrl('decks/export', array('id' => $deck->deckId, 'type' => 'html')); ?>"><img src="_resources/images/icon-x16-html.png" title="Export as HTML" /></a>
        &nbsp;&nbsp;
        <a href="<?php echo $this->createUrl('decks/export', array('id' => $deck->deckId, 'type' => 'pdf')); ?>"><img src="_resources/images/icon-x16-document-pdf.png" title="Export as PDF" /></a>
    </p>
</div>
<div class="span-11 last centered">
    <h3>Preview</h3>
    <!-- //TODO: remove the fixed width -->
    <img src="_game/cards/cardback.jpg" width="250px" id="previewImage" />
</div>