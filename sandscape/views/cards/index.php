<?php $this->title = 'Card List'; ?>
<h2>Card List</h2>
<div class="list-tools">
    <a href="<?php echo $this->createURL('create'); ?>">Create Card</a>
    <a href="<?php echo $this->createURL('import'); ?>">CSV Import</a>
</div>
<?php
$this->widget('zii.widgets.grid.CGridView', array(
    'id' => 'card-grid',
    'dataProvider' => $filter->search(),
    'filter' => $filter,
    'cssFile' => false,
    'columns' => array(
        array(
            'name' => 'name',
            'type' => 'html',
            'value' => 'CHtml::link($data->name, Yii::app()->createUrl("cards/update", array("id" => $data->cardId)))'
        ),
        array(
            'header' => 'Actions',
            'class' => 'CButtonColumn',
            'buttons' => array(
                'view' => array('visible' => 'false')
            )
        )
    ),
    'template' => '{items} {pager} {summary}'
));

/*
 * $this->widget('bootstrap.widgets.TbGridView', array(
    'id' => 'cliente-grid',
    'type' => 'striped condensed',
    'dataProvider' => $filter->search(),
    'filter' => $filter,
    'template' => '{items} {pager} {summary}',
    'columns' => array(
        array(
            'name' => 'username',
            'type' => 'raw',
            'value' => 'CHtml::link("{$data->username}", Yii::app()->createUrl("users/update", array("id" => $data->userID)))'
        ),
        array(
            'class' => 'bootstrap.widgets.TbButtonColumn',
            'htmlOptions' => array('style' => 'width: 50px'),
            'header' => Yii::t('oppas', 'Actions'),
            'buttons' => array(
                'view' => array('visible' => 'false'),
            ),
        ),
    ),
));

$this->widget('bootstrap.widgets.TbButton', array(
    'url' => $this->createUrl('users/create'),
    'label' => Yii::t('oppas', 'Create'),
    'type' => 'info'
));
 * 

/** @var UsersController $this
/** @var BootActiveForm $form 
$form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
    'id' => 'user-form',
    'enableAjaxValidation' => true,
    'type' => 'horizontal',
    'htmlOptions' => array('class' => 'well'),
        ));

echo $form->textFieldRow($user, 'username', array('maxlength' => 40));
echo $form->passwordFieldRow($user, 'password');
echo $form->passwordFieldRow($user, 'password_repeat');

<div class="settings">

    $this->widget('bootstrap.widgets.TbButton', array(
        'buttonType' => 'submit',
        'label' => Yii::t('oppas', 'Save'),
        'type' => 'success'
    ));

    $this->widget('bootstrap.widgets.TbButton', array(
        'url' => $this->createUrl('users/index'),
        'label' => Yii::t('oppas', 'Cancel'),
        'type' => 'warning'
    ));

</div>

$this->endWidget();

 */