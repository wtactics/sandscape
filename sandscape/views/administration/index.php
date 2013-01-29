<?php
if (YII_DEBUG) {
    Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/css/development/administration.css');
}

$this->title = 'Sandscape Administration';
?>
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
            'view' => '_gamesettings',
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