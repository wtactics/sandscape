<?php $this->title = 'Deck Templates'; ?>
<h2>Manage Deck Templates</h2>
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
                'view' => array('visible' => 'false'),
                'update' => array('visible' => 'false'),
            )
        ),
    ),
));
?>
