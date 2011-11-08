<?php $this->title = 'States'; ?>
<h2>Manage States</h2>
<div class="span-22 last">
    <a href="<?php echo $this->createURL('create'); ?>">Create State</a>
</div>
<?php
$this->widget('zii.widgets.grid.CGridView', array(
    'id' => 'state-grid',
    'dataProvider' => $filter->search(),
    'filter' => $filter,
    'columns' => array(
        'name',
        array(
            'header' => 'Actions',
            'class' => 'CButtonColumn',
            'buttons' => array(
                'view' => array('visible' => false)
            )
        )
    )
));