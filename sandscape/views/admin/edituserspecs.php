<?php

return array(
    'title' => 'User Data',
    'elements' => array(
        'name' => array(
            'type' => 'text',
            'maxlength' => 20,
            'visible' => true
        ),
        'email' => array(
            'type' => 'text',
            'maxlength' => 200,
            'visible' => true
        ),
        'password' => array(
            'type' => 'password',
            'maxlength' => 40,
            'visible' => true
        ),
        'key' => array(
            'type' => 'text',
            'maxlength' => 40,
            'visible' => true
        ),
    //'visited' => array(
    //    'type' => 'text',
    //    'maxlength' => 32,
    //),
    ),
    'buttons' => array(
        'update' => array(
            'type' => 'submit',
            'label' => 'Save',
        ),
    ),
);
