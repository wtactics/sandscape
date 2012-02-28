<?php
$this->title = 'Users';

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

<div class="span-22 last"><a href="<?php echo $this->createURL('create'); ?>">Create User</a></div>
<?php
$this->widget('zii.widgets.grid.CGridView', array(
    'id' => 'user-grid',
    'dataProvider' => $filter->search(),
    'filter' => $filter,
    'columns' => array(
        'name',
        array(
            'name' => 'email',
            'type' => 'email'
        ),
        array(
            'name' => 'admin',
            'filter' => array(0 => 'Regular', 1 => 'Administrator'),
            'type' => 'raw',
            'value' => '($data->admin ? "Administrator" : "Regular")'
        ),
        array(
            'header' => 'Actions',
            'class' => 'CButtonColumn',
            'buttons' => array(
                'view' => array('visible' => 'false'),
                'reset' => array(
                    'label' => 'Reset Password',
                    'url' => 'Yii::app()->createUrl("users/resetpassword", array("id" => $data->userId))',
                    'imageUrl' => '_resources/images/icon-x16-key.png',
                    'visible' => 'true',
                    'options' => array('class' => 'reset')
                )
            ),
            'template' => '{update} {delete} {reset}'
        )
    ),
    'template' => '{items} {pager} {summary}'
));