<?php $this->title = 'Tokens'; ?>
<h2>Manage Tokens</h2>
<div class="span-22 last">
    <a href="<?php echo $this->createURL('create'); ?>">Create Token</a>
</div>
<?php
$this->widget('zii.widgets.grid.CGridView', array(
    'id' => 'token-grid',
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