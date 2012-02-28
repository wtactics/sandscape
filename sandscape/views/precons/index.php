<?php $this->title = 'Pre-constructed Decks'; ?>
<h2>Manage Pre-constructed Decks</h2>

<div class="span-22 last"><a href="<?php echo $this->createURL('decks/create'); ?>">Create Pre-constructed Deck</a></div>
<?php
$this->widget('zii.widgets.grid.CGridView', array(
    'id' => 'decktemplate-grid',
    'dataProvider' => $filter->search(),
    'filter' => $filter,
    'columns' => array(
        'name',
        array(
            'name' => 'created',
            'type' => 'date',
            'value' => 'strtotime($data->created)',
            'filter' => false
        ),
        array(
            'header' => 'Actions',
            'class' => 'CButtonColumn',
            'buttons' => array(
                //TODO: make view direct administrator to decks/view
                'view' => array('visible' => 'false'),
                'update' => array('visible' => 'false'),
            )
        ),
    ),
    'template' => '{items} {pager} {summary}'
));