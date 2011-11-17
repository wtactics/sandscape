<?php
Yii::app()->clientScript->registerCssFile('_resources/css/sandscape/administration' . (YII_DEBUG ? '' : '.min') . '.css');

Yii::app()->clientScript->registerCssFile('_resources/css/thirdparty/jquery.bubblepopup.v2.3.1.css');
Yii::app()->clientScript->registerScriptFile('_resources/js/thirdparty/jquery.bubblepopup.v2.3.1.min.js', CClientScript::POS_HEAD);

$js = <<<JS
$('.helpicon').CreateBubblePopup({
    position: 'right',
    align: 'center',
    tail: {
        align: 'center'
    },
    themeName: 'all-black',
    themePath: '_resources/images/jqBubblePopup',
    alwaysVisible: false,
    closingDelay: 100
});

JS;

Yii::app()->clientScript->registerScript('bublesinit', $js);

$this->title = 'Sandscape Administration';
?>
<div class="span-22 last">
    <h2>SandScape Administration</h2>
    <?php
    $this->widget('CTabView', array(
        'tabs' => array(
            'tStats' => array(
                'title' => 'Stats',
                'view' => '_stats',
            ),
            'tSSettings' => array(
                'title' => 'Settings',
                'view' => '_settings',
                'data' => array('settings' => $settings)
            ),
            'tGSettings' => array(
                'title' => 'Game Options',
                'view' => '_game-settings',
                'data' => array('settings' => $settings)
            ),
            'tTools' => array(
                'title' => 'Tools',
                'view' => '_tools'
            ),
            'tWords' => array(
                'title' => 'Word Filter',
                'view' => '_wordfilter',
                'data' => array('words' => $settings['wordfilter']->value)
            )
        ),
        'cssFile' => '_resources/css/sandscape/tabs' . (YII_DEBUG ? '' : '.min') . '.css'
    ));
    ?>
</div>
