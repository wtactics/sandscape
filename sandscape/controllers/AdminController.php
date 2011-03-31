<?php

class AdminController extends CController {

    public function actionIndex() {
        $provider = new CActiveDataProvider('User', array(
                    'criteria' => array(
                        'condition' => 'active = 1',
                        'order' => 'name, email, active',
                    ),
                    'pagination' => array(
                        'pageSize' => 20,
                    ),
                ));
        $this->render('index', array('users' => $provider));
    }

    public function actionUpdate($id) {
        $user = User::model()->find('userId = :userId', array(':userId' => $id));

        $form = new CForm('application.views.admin.edituserspecs', $user);
        if ($form->submitted('update') && $form->validate()) {
            
        } else {
            $this->render('edituser', array('form' => $form));
        }
    }

    public function actionDelete($id) {

        $user = User::model()->find('userId = :userId', array(':userId' => $id));
        $user->setAttribute('active', 0);
        $user->save();
    }

    public function actionCreate() {
        $new = new User();

        //...
    }

}

