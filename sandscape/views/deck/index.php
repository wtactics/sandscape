<h2>Manage Decks</h2>
<div class="span-2 prepend-22 last"><a href="<?php echo $this->createURL('create'); ?>">New Deck</a></div>
<?php
$this->widget('zii.widgets.grid.CGridView', array(
    'id' => 'deck-grid',
    'dataProvider' => $filter->search(Yii::app()->user->getId()),
    'filter' => $filter,
    'columns' => array(
        'deckId',
        'name',
        'userId',
        'created',
        'active',
        array(
            'class' => 'CButtonColumn',
        ),
    ),
));
?>
