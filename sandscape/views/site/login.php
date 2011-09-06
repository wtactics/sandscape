<?php
/*
 * Controller.php
 * 
 * This file is part of SandScape.
 * 
 * SandScape is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 * 
 * SandScape is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 * 
 * You should have received a copy of the GNU General Public License
 * along with SandScape.  If not, see <http://www.gnu.org/licenses/>.
 * 
 * Copyright (c) 2011, the SandScape team and WTactics project.
 */
?><div class="form" style="width: 50%; margin: 0 auto;">
    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'login-form'
            ));
    ?>
    <h3>Login to Play</h3>
    <p>
        <?php
        echo $form->labelEx($model, 'email'),
        $form->textField($model, 'email'),
        $form->error($model, 'email');
        ?>
    </p>

    <p>
        <?php
        echo $form->labelEx($model, 'password'),
        $form->passwordField($model, 'password'),
        $form->error($model, 'password');
        ?>
    </p>

    <p>
        <?php
        echo $form->checkBox($model, 'rememberMe'),
        $form->label($model, 'rememberMe'),
        $form->error($model, 'rememberMe');
        ?>
    </p>
    <p>
        <?php echo CHtml::submitButton('Login'); ?>
    </p>

    <?php $this->endWidget(); ?>
</div><!-- form -->
