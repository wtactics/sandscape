<?php
/** @var $this UsersController */
$this->widget('bootstrap.widgets.TbDetailView', array(
    'data' => $user,
    'attributes' => array(
        'id',
        'name',
        'email:email',
        array(
            'name' => 'gender',
            'value' => $user->getGenderName()
        ),
        'birthyear',
        'website:url',
        'twitter',
        'facebook',
        'googleplus:url',
        'skype',
        array(
            'name' => 'county',
            'value' => $user->getCountryName()
        ),
        array(
            'name' => 'reverseCards',
            'value' => $user->showReversedCards()
        ),
        array(
            'name' => 'onHoverDetails',
            'value' => $user->showDetailsOnHover()
        ),
        array(
            'name' => 'role',
            'value' => $user->getRoleName()
        )
    ),
));

$this->widget('bootstrap.widgets.TbButton', array(
    'url' => $this->createUrl('users/update', array('id' => $user->id)),
    'label' => Yii::t('interface', 'Edit'),
    'type' => 'info'
));