<?php $this->title = 'Games'; ?>
<h2>Game List</h2>
<?php
$this->widget('zii.widgets.grid.CGridView', array(
    'id' => 'game-grid',
    'dataProvider' => $filter->search(),
    'filter' => $filter,
    'columns' => array(
        //array(
        //    'header' => 'Opponent',  
        //)
        array(
            'name' => 'created',
            'type' => 'date',
            'value' => 'strtotime($data->created)'
        ),
        array(
            'name' => 'started',
            'type' => 'date',
            'value' => 'strtotime($data->started)'
        ),
        array(
            'name' => 'ended',
            'type' => 'date',
            'value' => 'strtotime($data->ended)'
        ),
        array(
            'name' => 'running',
            'filter' => array(0 => 'No', 1 => 'Yes'),
        ),
        array(
            'name' => 'paused',
            'filter' => array(0 => 'No', 1 => 'Yes'),
        ),
        array(
            'header' => 'Actions',
            'class' => 'CButtonColumn',
            'buttons' => array(
                'delete' => array('visible' => 'false'),
                'update' => array('visible' => 'false')
            )
        )
    )
));