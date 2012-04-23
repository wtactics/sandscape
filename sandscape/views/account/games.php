<?php $this->title = 'Game List'; ?>

<h2>Game List</h2>
<?php
$this->widget('zii.widgets.grid.CGridView', array(
    'id' => 'game-grid',
    'dataProvider' => $filter->search(),
    'filter' => $filter,
    'ajaxUrl' => $this->createURL('account/games'),
    'columns' => array(
        array(
            'name' => 'created',
            'type' => 'date',
            'value' => 'strtotime($data->created)'
        ),
        array(
            'name' => 'started',
            'type' => 'date',
            'value' => '($data->started ? strtotime($data->started) : null)'
        ),
        array(
            'name' => 'ended',
            'type' => 'date',
            'value' => '($data->ended ? strtotime($data->ended) : null)'
        ),
        array(
            'name' => 'running',
            'filter' => array(0 => 'No', 1 => 'Yes'),
            'type' => 'raw',
            'value' => '($data->running ? \'<span class="yes">Yes</span>\' : \'<span class="no">No</span>\')'
        ),
        array(
            'name' => 'paused',
            'filter' => array(0 => 'No', 1 => 'Yes'),
            'type' => 'raw',
            'value' => '($data->paused ? \'<span class="yes">Yes</span>\' : \'<span class="no">No</span>\')'
        ),
        array(
            'header' => 'Actions',
            'class' => 'CButtonColumn',
            'buttons' => array(
                'view' => array(
                    'url' => "Yii::app()->createUrl('account/game', array('id' => \$data->gameId))",
                ),
                'delete' => array('visible' => 'false'),
                'update' => array('visible' => 'false')
            )
        )
    ),
    'template' => '{items} {pager} {summary}'
));