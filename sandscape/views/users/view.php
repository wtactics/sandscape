<?php
/** @var $this UsersController */
$this->widget('bootstrap.widgets.TbDetailView', array(
    'data' => $user,
    'attributes' => array(
        'userId',
        'name',
        'email:email',
        array(
            'name' => 'gender',
            'value' => $user->getGender()
        ),
        'birthyear',
        'website:url',
        'twitter',
        'facebook',
        'googleplus:url',
        'skype',
        array(
            'name' => 'county',
            'value' => $user->getCountry()
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
            'value' => $user->getRole()
        )
    ),
));

$this->widget('bootstrap.widgets.TbButton', array(
    'url' => $this->createUrl('users/update', array('id' => $user->userId)),
    'label' => Yii::t('sandscape', 'Edit'),
    'type' => 'info'
));