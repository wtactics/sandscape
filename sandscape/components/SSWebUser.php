<?php

class SSWebUser extends CWebUser {

    public function beforeLogin($id, $states, $fromCookie) {

        if (!$fromCookie) {
            return true;
        }

        $sd = SessionData::model()->findByPk($id);
        if ($sd === null || $sd->token !== $states['token'] || strtotime($sd->tokenExpires) < time()) {
            return false;
        }

        return false;
    }

}
