<?php $this->title = 'Dice'; ?>
<h2>Manage Dice</h2>
<div class="span-22 last">
    <a href="<?php echo $this->createURL('create'); ?>">New Dice</a>
</div>
<?php
$this->widget('zii.widgets.grid.CGridView', array(
    'id' => 'dice-grid',
    'dataProvider' => $filter->search(),
    'filter' => $filter,
    'columns' => array(
        'name',
        'face',
        array(
            'header' => 'Actions',
            'class' => 'CButtonColumn',
            'buttons' => array(
                'view' => array('visible' => 'false'),
            )
        ),
    ),
));
?>