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

    <p class="note">Fields with <span class="required">*</span> are required.</p>

    <div class="row">
        
        <div class="leftformcolum"><?php echo $form->labelEx($model, 'email'); ?></div>
        <div class="rightformcolum"><?php echo $form->textField($model, 'email'); ?></div>
        <div class="formfielderror"><?php echo $form->error($model, 'email'); ?></div>
    </div>

    <div class="row">
        <div class="leftformcolum"><?php echo $form->labelEx($model, 'password'); ?></div>
        <div class="rightformcolum"><?php echo $form->passwordField($model, 'password'); ?></div>
        <div class="formfielderror"><?php echo $form->error($model, 'password'); ?></div>
    </div>

    <div class="row rememberMe">
        <div class="leftformcolum"><?php echo $form->checkBox($model, 'rememberMe'); ?></div>
        <div class="rightformcolum"><?php echo $form->label($model, 'rememberMe'); ?></div>
        <div class="formfielderror"><?php echo $form->error($model, 'rememberMe'); ?></div>
    </div>

    <div class="row buttons">
        <?php echo CHtml::submitButton('Login'); ?>
    </div>

    <?php $this->endWidget(); ?>
</div><!-- form -->
