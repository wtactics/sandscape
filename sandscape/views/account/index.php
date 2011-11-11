<?php
$this->title = 'Account';

Yii::app()->clientScript->registerCssFile('_resources/css/sandscape/forms' . (YII_DEBUG ? '' : '.min') . '.css');
?>

<h2>Account</h2>
<?php
$this->widget('CTabView', array(
    'tabs' => array(
        'tStats' => array(
            'title' => 'Stats',
            'view' => '_stats',
            'data' => array()
        ),
        'tGeneral' => array(
            'title' => 'General',
            'view' => '_personal',
            'data' => array('user' => $user)
        ),
        'tPassword' => array(
            'title' => 'Password',
            'view' => '_password',
            'data' => array('pwdModel' => $pwdModel)
        )
    ),
    'cssFile' => '_resources/css/sandscape/tabs' . (YII_DEBUG ? '' : '.min') . '.css'
));