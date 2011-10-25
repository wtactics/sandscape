<?php $this->title = 'Sandscape Administration'; ?>
<div class="span-22 last">
    <h2>SandScape Administration</h2>
    <?php
    $this->widget('CTabView', array(
        'tabs' => array(
            'tab1' => array(
                'title' => 'Stats',
                'view' => '_stats',
            ),
            'tab2' => array(
                'title' => 'Settings',
                'view' => '_settings',
                'data' => array()
            ),
            'tab3' => array(
                'title' => 'Word Filter',
                'view' => '_wordfilter',
                'data' => array()
            )
        )
    ));
    ?>
</div>
