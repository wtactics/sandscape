<?php
Yii::app()->clientScript->registerCssFile('_resources/css/deckediting.css');
Yii::app()->clientScript->registerCoreScript('jquery.ui');
Yii::app()->clientScript->registerScript('cardui', "
$('.dragme').draggable({
    containment: 'document', 
    stack: '.dragme'
});

$('#usecards').droppable({
    accept: '.dragme',
    drop: function(event, ui) {
        var destination  = $('#usecards');
        var padding = (destination.children().length) * 25;

        $(ui.draggable).removeClass('dragme')
                .removeAttr('style')
                .detach()
                .addClass('chosen')
                .appendTo(destination).
                css({'left': padding});
    }
});
    ");
?>
<div class="span-12 append-1">
    <h2><?php echo ($deck->isNewRecord ? 'Create Deck' : 'Edit Deck'); ?></h2>
    <?php echo $this->renderPartial('_form', array('deck' => $deck)); ?>

    <div class="span-12 last">
        <h3>Cards in deck</h3>
        <div id="usecards">
        </div>
    </div>
</div>
<div class="span-11 last">
    <h2>Existing cards</h2>
    <div id="existingcards">
        <?php foreach ($cards as $card) { ?>
            <img class="dragme" src="_cards/up/thumbs/<?php echo $card->image; ?>" title="<?php echo $card->name; ?>" />
        <?php } ?>
    </div>
</div>