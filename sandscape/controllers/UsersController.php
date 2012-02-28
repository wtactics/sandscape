<?php

/* UsersController.php
 * 
 * This file is part of Sandscape, a virtual, browser based, table allowing 
 * people to play a customizable card games (CCG) online.
 *
 * Copyright (c) 2011, the Sandscape team.
 * 
 * Sandscape uses several third party libraries and resources, a complete list 
 * can be found in the <README> file and in <_dev/thirdparty/about.html>.
 * 
 * Sandscape's team members are listed in the <CONTRIBUTORS> file.
 * 
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Affero General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 * 
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU Affero General Public License for more details.
 * 
 * You should have received a copy of the GNU Affero General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */

/**
 * Manages users. Does not provide user registration or login and logout 
 * actions as thoses are handled by the <em>SiteController</em> class.
 * 
 * This class was renamed from <em>UserController</em> after all profile/account 
 * related actions were removed and only administration actions were left.
 * 
 * @since 1.2, Elvish Shaman
 */
class UsersController extends AppController {

    public function __construct($id, $module = null) {
        parent::__construct($id, $module);
    }

    /**
     * Lists all existing users.
     * 
     * @since 1.2, Elvish Shaman
     */
    public function actionIndex() {
        $filter = new User('search');
        $filter->unsetAttributes();

        if (isset($_POST['User'])) {
            $filter->attributes = $_POST['User'];
        }

        $this->render('index', array('filter' => $filter));
    }

    /**
     * Adds a new user to the system.
     * 
     * @since 1.2, Elvish Shaman
     */
    public function actionCreate() {
        $new = new User();
        
        $this->performAjaxValidation('user-form', $new);

        if (isset($_POST['User'])) {
            $new->attributes = $_POST['User'];
            if ($new->save()) {
                $this->redirect(array('update', 'id' => $new->userId));
            }
        }

        $this->render('edit', array('user' => $new));
    }

    /**
     * Updates a user's information, this action is only available to administrators.
     * 
     * @param integer $id The user ID that we want to update.
     * 
     * @since 1.2, Elvish Shaman
     */
    public function actionUpdate($id) {
        $user = $this->loadUserModel($id);

        $this->performAjaxValidation('user-form', $user);

        if (isset($_POST['User'])) {
            $user->attributes = $_POST['User'];
            if ($user->save()) {
                $this->redirect(array('update', 'id' => $user->userId));
            }
        }

        $this->render('edit', array('user' => $user));
    }

    /**
     * Handles the AJAX request for user deletion. Only POST requests are valid 
     * and only if the user making the request is and administrator.
     * 
     * @param integer $id User ID
     * 
     * @since 1.2, Elvish Shaman
     */
    public function actionDelete($id) {
        if (Yii::app()->request->isPostRequest && Yii::app()->user->class) {
            $user = $this->loadUserModel($id);
            if ($user) {
                $user->active = 0;
                $user->save();
            }
        } else {
            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
        }
    }

    /**
     * Resets a user's password by creating a new random password and sending an 
     * e-mail to the user. The new password is sent in the e-mail and the standard 
     * hash e placed in the user's database record.
     * 
     * To be able to use this action a system e-mail must be configured.
     * 
     * @param integer $id User ID
     * 
     * @since 1.3, Soulharvester
     */
    public function actionResetPassword($id) {
        if (Yii::app()->request->isPostRequest && Yii::app()->user->class) {
            $user = $this->loadUserModel($id);

            if (($setting = Setting::model()->findByPk('sysemail')) !== null && $setting->value != '') {
                $from = $setting->value;

                if ($user) {
                    $a = 'aeiou';
                    $b = 'bcdfghjklmnpqrstvwxyz';
                    $c = '1234567890';
                    $d = '+#&@';

                    $password = '';
                    for ($i = 0; $i < 8; $i++) {
                        switch (rand(0, 5)) {
                            case 0:
                                $password .= $a[rand(0, strlen($a))];
                                break;
                            case 1:
                                $password .= $b[rand(0, strlen($a))];
                                break;
                            case 2:
                                $password .= $c[rand(0, strlen($c))];
                                break;
                            case 3:
                                $password .= strtoupper($a[rand(0, strlen($a))]);
                                break;
                            case 4:
                                $password .= $d[rand(0, strlen($d))];
                                break;
                            case 5:
                                $password .= strtoupper($b[rand(0, strlen($b))]);
                                break;
                        }
                    }

                    $user->password = User::hash($password);
                    if ($user->save()) {

                        Yii::import('ext.email.*');

                        $mailer = new PHPMailer();
                        $mailer->AddAddress($user->email, $user->name);
                        $mailer->From = $from;
                        $mailer->Subject = 'Password reset by administrator';
                        $mailer->Body = "An administrator reset your password. Your new password is: {$password} \n\nSent by SandScape, please don't replay to this e-mail.";

                        try {
                            $mailer->Send();
                            echo json_encode(array('error' => 0));
                        } catch (phpmailerException $pe) {
                            echo json_encode(array('error' => 'Unable to send e-mail.'));
                        }
                    }
                }
            } else {
                echo json_encode(array('error' => 'Unable to process the request. Please configure the system e-mail.'));
            }
        } else {
            echo json_encode(array('error' => 'Invalid request. Please do not repeat this request again.'));
        }
    }

    /**
     * Loads a <em>User</em> model from the database
     * @param integer $id The user ID.
     * @return User The loaded user model.
     * 
     * @since 1.2, Elvish Shaman
     */
    private function loadUserModel($id) {
        if (($user = User::model()->find('active = 1 AND userId = :id', array(':id' => (int) $id))) === null) {
            throw new CHttpException(404, 'The user you are trying to load doesn\'t exist.');
        }
        return $user;
    }

    /**
     * Overrides the default rules allowing for user actions. Authenticated users 
     * can view profile and stats information and change their own accounts.
     * 
     * Administrators are allowed to create new users, update information or 
     * delete existing users.
     * 
     * @return array Rules array.
     * 
     * @since 1.0, Sudden Growth
     */
    public function accessRules() {
        return array_merge(array(
                    array('allow',
                        'actions' => array('index', 'create', 'update', 'delete',
                            'resetpassword'
                        ),
                        'expression' => '$user->class'
                    )
                        ), parent::accessRules());
    }

}
