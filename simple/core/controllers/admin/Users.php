<?php

/*
 * Users.php
 *
 * (C) 2011, StaySimple team.
 *
 * This file is part of StaySimple.
 * http://code.google.com/p/stay-simple-cms/
 *
 * StaySimple is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * StaySimple is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with StaySimple.  If not, see <http://www.gnu.org/licenses/>.
 */

class Users extends Administration {

    private $manager;

    public function __construct() {
        parent::__construct();

        $this->validateUser();
        $this->manager = new UserManager();
    }

    public function start() {
        $this->render('users', array('content' => 'users', 'users' => $this->manager->getAllUsers()));
    }

    public function edit($params = array()) {
        $user = new User();

        if (isset($params[0]) && $params[0] != '') {
            $query = $this->manager->getUserById($params[0]);
            if ($query) {
                $user = $query;
            }
        }

        if (isset($_POST['User'])) {
            if (!isset($_POST['email'])) {
                $this->queueMessage(new Message($this->getTranslatedString('STAY_USER_EMAIL_IS_REQUIRED'), Message::$ERROR));
            } else {
                $error = false;
                if ($_POST['userId'] == '') {
                    $id = User::generateId($_POST['email']);
                    if ($this->manager->getUserById($id)) {
                        $this->queueMessage(new Message($this->getTranslatedString('STAY_USER_ALREADY_EXISTS'), Message::$ERROR));
                        $error = true;
                    }
                }

                if (!$error && isset($_POST['password']) && $_POST['password'] != '') {
                    if ($_POST['password'] === $_POST['rpassword']) {
                        $user->setPassword(User::getPasswordHash($_POST['password'], Config::getInstance()->get('system.hash')));
                    } else {
                        $this->queueMessage(new Message($this->getTranslatedString('STAY_USER_PASSWORDS_DONT_MATCH'), Message::$ERROR));
                        $error = true;
                    }
                }

                if (!$error) {
                    if (isset($_POST['active'])) {
                        $user->setActive($_POST['active']);
                    } else {
                        $user->setActive(0);
                    }

                    if (isset($_POST['name'])) {
                        $user->setName($_POST['name']);
                    }
                    $user->setEmail($_POST['email']);

                    $this->manager->update($user);
                    if (!$this->manager->save()) {
                        $this->queueMessage(new Message($this->getTranslatedString('STAY_USER_SAVE_ERROR'), Message::$ERROR));
                        $error = true;
                    }
                }

                if (!$error) {
                    $this->queueMessage(new Message($this->getTranslatedString('STAY_USER_SAVE_SUCCESS')));
                }
            }
        }

        $this->render('user-edit', array('content' => 'useredit', 'user' => $user));
    }

    public function delete($params = array()) {
        if (isset($params[0]) && $params[0] != '') {
            if (!$this->manager->deleteUserById($params[0])) {
                $this->queueMessage(new Message($this->getTranslatedString('STAY_USER_DELETE_ONE_ERROR'), Message::$ERROR));
            } else {
                $this->queueMessage(new Message($this->getTranslatedString('STAY_USER_DELETE_SELECTED_ERROR')));
            }
        } else {
            $this->queueMessage(new Message($this->getTranslatedString('STAY_USER_INVALID'), Message::$ERROR));
        }

        $this->redirect('users');
    }

    public function account() {
        $user = StaySimple::app()->getUser();
        if (!$user) {
            $this->queueMessage(new Message($this->getTranslatedString('STAY_USER_ACCOUNT_INVALID'), Message::$ERROR));
            $this->redirect('users');
        }

        if (isset($_POST['User'])) {
            if (!isset($_POST['email'])) {
                $this->queueMessage(new Message($this->getTranslatedString('STAY_USER_EMAIL_IS_REQUIRED'), Message::$ERROR));
            } else {

                $error = false;
                $data = array();
                if (isset($_POST['password']) && $_POST['password'] != '') {
                    if ($_POST['password'] === $_POST['rpassword']) {
                        $user->setPassword(User::getPasswordHash($_POST['password'], Config::getInstance()->get('system.hash')));
                    } else {
                        $this->queueMessage(new Message($this->getTranslatedString('STAY_USER_PASSWORDS_DONT_MATCH'), Message::$ERROR));
                        $error = true;
                    }
                }

                if (!$error) {
                    if (isset($_POST['active'])) {
                        $user->setActive($_POST['active']);
                    } else {
                        $user->setActive(0);
                    }

                    if (isset($_POST['name'])) {
                        $user->setName($_POST['name']);
                    }
                    $user->setEmail($_POST['email']);

                    $this->manager->update($user);
                    if (!$this->manager->save()) {
                        $this->queueMessage(new Message($this->getTranslatedString('STAY_USER_SAVE_XML_ERROR'), Message::$ERROR));
                        $error = true;
                    }
                }

                if (!$error) {
                    $this->queueMessage(new Message($this->getTranslatedString('STAY_USER_CHANGES_SAVED_SUCCESS')));
                }
            }
        }

        $this->render('user-account', array('user' => $user));
    }

}