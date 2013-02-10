<?php
/** @var $this UsersController */
$this->title = Yii::t('interface', 'Users');
?>

<h2><?php echo Yii::t('interface', 'User List'); ?></h2>

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
            'value' => 'CHtml::link($data->name, Yii::app()->createUrl("users/update", array("id" => $data->id)))'
        ),
        'email:email',
        array(
            'name' => 'role',
            'filter' => User::rolesArray(),
            'type' => 'html',
            'value' => '$data->getRoleName()'
        ),
        array(
            'header' => Yii::t('interface', 'Actions'),
            'class' => 'bootstrap.widgets.TbButtonColumn',
            'htmlOptions' => array('style' => 'width: 50px'),
        )
    ),
));

$this->widget('bootstrap.widgets.TbButton', array(
    'label' => Yii::t('interface', 'New User'),
    'type' => 'info',
    'size' => 'small',
    'url' => $this->createURL('users/create')
));
