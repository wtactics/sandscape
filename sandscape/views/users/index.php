<?php
$this->title = Yii::t('sandscape', 'Users');

$js = <<<JS
$('a.reset').click(function() {
    if(!confirm('Are you sure you want reset this user\'s password?')) {
        return false;
    }
    
    $.ajax ({
        type: 'POST',
        dataType: 'json',
        url: $(this).attr('href'),
        success: function(json) {
            if(json != null && json.error) {
                alert(json.error);
            }
        }
    });
    
    return false;
});
JS;

Yii::app()->clientScript->registerScript('resetjs', $js);
?>

<h2>User List</h2>

<div class="list-tools">
    <a href="<?php echo $this->createURL('create'); ?>">Create User</a>
</div>

<?php
$this->widget('bootstrap.widgets.TbGridView', array(
    'id' => 'user-grid',
    'dataProvider' => $filter->search(),
    'filter' => $filter,
    'template' => '{items} {pager} {summary}',
    'type' => 'striped condensed bordered',
    'columns' => array(
        array(
            'name' => 'name',
            'type' => 'html',
            'value' => 'CHtml::link($data->name, Yii::app()->createUrl("users/update", array("id" => $data->userId)))'
        ),
        'email:email',
        array(
            'name' => 'role',
            'filter' => User::rolesArray(),
            'type' => 'raw',
            'value' => '($data->role == 2 ? "Administrator" : ($data->role == 1 ? "Power User" : "Regular"))'
        ),
        array(
            'class' => 'bootstrap.widgets.TbButtonColumn',
            'htmlOptions' => array('style' => 'width: 50px'),
        )

//        array(
//            'header' => Yii::t('sandscape', 'Actions'),
//            'class' => 'CButtonColumn',
//            'buttons' => array(
//                'view' => array('visible' => 'false'),
    //'reset' => array(
    //    'label' => 'Reset Password',
    //    'url' => 'Yii::app()->createUrl("users/resetpassword", array("id" => $data->userId))',
    //    'imageUrl' => '_resources/images/icon-x16-key.png',
    //    'visible' => 'true',
    //    'options' => array('class' => 'reset')
    //)
//            ),
//            'template' => '{update} {delete} {reset}'
    //)
    ),
));