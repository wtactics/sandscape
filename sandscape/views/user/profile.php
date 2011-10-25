<?php
$this->title = 'Edit Profile';

Yii::app()->clientScript->registerCssFile('_resources/css/forms.css');
?>

<h2>Edit Profile</h2>
<?php
$this->widget('CTabView', array(
    'tabs' => array(
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
    )
));
?>