<?php $this->title = 'Cards'; ?>
<h2>Card List</h2>
<div class="span-2 prepend-20 last"><a href="<?php echo $this->createURL('create'); ?>">New Card</a></div>
<?php
$this->widget('zii.widgets.grid.CGridView', array(
    'id' => 'card-grid',
    'dataProvider' => $filter->search(),
    'filter' => $filter,
    'columns' => array(
        'name',
        array(
            'header' => 'Actions',
            'class' => 'CButtonColumn',
        )
    )
));
?>
