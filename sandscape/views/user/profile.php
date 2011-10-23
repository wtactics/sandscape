<?php
Yii::app()->clientScript->registerCssFile('_resources/css/tabs.css');
Yii::app()->clientScript->registerScript('tabsjs', "
    $('#tabs div').hide();
    $('#tabs div:first').show();
    $('#tabs ul li:first').addClass('active');
    $('#tabs ul li a').click(function() {
        $('#tabs ul li').removeClass('active');
        $(this).parent().addClass('active');
        var currentTab = $(this).attr('href');
        $('#tabs div').hide();
        $(currentTab).show();
        return false;
    });
");

$this->title = 'Edit Profile';
?>

<h2>Edit Profile</h2>
<div id="tabs">
    <ul>
        <li><a href="#tab1">General</a></li>
        <li><a href="#tab2">Password</a></li>
    </ul>
    <div id="tab1">
        <?php $this->renderPartial('_personal', array('user' => $user)) ?>
    </div>
    <div id="tab2">
        <?php $this->renderPartial('_password', array('pwdModel' => $pwdModel)); ?>
    </div>
</div>
