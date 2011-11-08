<?php $this->title = 'Games'; ?>
<h2>Game List</h2>
<?php
$this->widget('zii.widgets.grid.CGridView', array(
    'id' => 'game-grid',
    'dataProvider' => $filter->search(),
    'filter' => $filter,
    'ajaxUrl' => $this->createURL('user/games'),
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
            'type' => 'raw',
            //TODO: use correct date format
            'value' => '($data->started ? date("d/m/Y", strtotime($data->started)) : "")'
        ),
        array(
            'name' => 'ended',
            'type' => 'raw',
            //TODO: use correct date format
            'value' => '($data->ended ? date("d/m/Y", strtotime($data->ended)) : "")'
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
                    'url' => "Yii::app()->createUrl('account/viewgame', array('id' => \$data->gameId))",
                ),
                'delete' => array('visible' => 'false'),
                'update' => array('visible' => 'false')
            )
        )
    )
));