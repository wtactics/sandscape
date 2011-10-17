<h2>Manage Decks</h2>

<?php
$this->widget('zii.widgets.grid.CGridView', array(
    'id' => 'deck-grid',
    'dataProvider' => $model->search(),
    'filter' => $model,
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
