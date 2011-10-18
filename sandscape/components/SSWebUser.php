<?php

class SSWebUser extends CWebUser {

    public function beforeLogin($id, $states, $fromCookie) {

        if (!$fromCookie) {
            return true;
        }

        $user = User::model()->findByPk($id);
        if ($user === null || $user->token !== $states['token'] || strtotime($user->tokenExpires) < time()) {
            return false;
        }

        return false;
    }

}
