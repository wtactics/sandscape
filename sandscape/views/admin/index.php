<div>
    <div style="float: left;width: 30%;">
        <ul>
            <li>Users</li>
            <li>Card Sync</li>
        </ul>
    </div>
    <div style="float: left;width: 65%;">
        <div id="admintools"><a href="#">New</a></div> 
        <?php
        $this->widget('zii.widgets.grid.CGridView', array(
            'dataProvider' => $users,
            'columns' => array(
                'userId',
                'name',
                'email',
                array(
                    'name' => 'active',
                    'value' => '($data->active ? "yes" : "no")',
                ),
                array(
                    'class' => 'CButtonColumn',
                    'buttons' => array('view' => array('visible' => 'false'))
                ),
            )
        ));
        ?>
    </div>
</div>
<div style="clear:both"></div>
