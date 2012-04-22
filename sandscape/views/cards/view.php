<?php $this->title = 'Card details for "' . CHtml::encode($card->name) . '"'; ?>
<h2>View Card</h2>

<?php
$this->widget('zii.widgets.CDetailView', array(
    'data' => $card,
    'attributes' => array(
        'name',
        'rules',
        array(
            'label' => 'Cardscape',
            'type' => 'raw',
            'value' => CHtml::link('Lookup this card at Cardscape', '#'),
            'visible' => $card->cardscapeId != 0
        ),
        array(
            'name' => 'image',
            'type' => 'raw',
            'value' => CHtml::image('_game/cards/' . $card->image)
        )
    ),
));
?>

<p>
    <a href="<?php echo $this->createUrl('cards/index'); ?>">Card list</a>
</p>