<?php
/** @var $this UsersController */
$this->title = Yii::t('sandscape', 'Users');
?>

<h2><?php echo Yii::t('sandscape', 'User List'); ?></h2>

<?php
$this->widget('bootstrap.widgets.TbGridView', array(
    'id' => 'user-grid',
    'dataProvider' => $filter->search(),
    'filter' => $filter,
    'columns' => array(
        array(
            'name' => 'name',
            'type' => 'html',
            'value' => 'CHtml::link($data->name, Yii::app()->createUrl("users/edit", array("id" => $data->id)))'
        ),
        'email:email',
//        array(
//            'name' => 'role',
//            'filter' => User::rolesArray(),
//            'type' => 'html',
//            'value' => '$data->getRoleName()'
//        ),
    ),
));
