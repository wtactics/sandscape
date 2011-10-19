<?php
Yii::app()->clientScript->registerCssFile('_resources/css/deck.css');
Yii::app()->clientScript->registerCoreScript('jquery.ui');
Yii::app()->clientScript->registerScriptFile('_resources/js/deck.js', CClientScript::POS_END);
?>
<div class="span-11 append-1">
    <h2><?php echo ($deck->isNewRecord ? 'Create Deck' : 'Edit Deck'); ?></h2>
    <?php echo $this->renderPartial('_form', array('deck' => $deck)); ?>

    <div class="span-11 last">
        <h3>Cards in deck</h3>
        <div id="usecards">
        </div>
        <input type="hidden" id="draggingTracker" value="" />
    </div>
</div>
<div class="span-12 last">
    <h2>Existing cards</h2>
    <div id="existingcards">
        <?php foreach ($cards as $card) { ?>
            <div class="draggable-container">
                <img class="available" src="_cards/up/thumbs/<?php echo $card->image; ?>" title="<?php echo $card->name; ?>" id="card-<?php echo $card->cardId; ?>" />
            </div>
        <?php } ?>
    </div>
</div>