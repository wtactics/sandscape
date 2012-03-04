<?php
$this->title = 'Account : Profile';

Yii::app()->clientScript->registerCssFile('_resources/css/sandscape/forms' . (YII_DEBUG ? '' : '.min') . '.css');
?>

<h2>Profile</h2>
<?php
$this->widget('CTabView', array(
    'tabs' => array(
        'tGeneral' => array(
            'title' => 'General',
            'view' => '_personal',
            'data' => array('user' => $user, 'countries' => $countries)
        ),
        'tPassword' => array(
            'title' => 'Password',
            'view' => '_password',
            'data' => array('pmodel' => $pmodel)
        ),
        'tAvatar' => array(
            'title' => 'Avatar',
            'view' => '_avatar',
            'data' => array('user' => $user, 'avatarSize' => $avatarSize)
        )
    ),
    'cssFile' => '_resources/css/sandscape/tabs' . (YII_DEBUG ? '' : '.min') . '.css'
));