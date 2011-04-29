<?php
/*
 * _form.php
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
?>
<div class="form">

    <?php
    $form = $this->beginWidget('CActiveForm', array(
                'id' => 'user-form',
                'enableAjaxValidation' => false,
            ));
    ?>

    <p class="note">Fields with <span class="required">*</span> are required.</p>

    <?php echo $form->errorSummary($model); ?>

    <div class="row">
        <div class="leftformcolum"><?php echo $form->labelEx($model, 'name'); ?></div>
        <div class="rightformcolum"><?php echo $form->textField($model, 'name', array('size' => 20, 'maxlength' => 20)); ?></div>
        <div class="formfielderror"><?php echo $form->error($model, 'name'); ?></div>
    </div>

    <div class="row">
        <div class="leftformcolum"><?php echo $form->labelEx($model, 'email'); ?></div>
        <div class="rightformcolum"><?php echo $form->textField($model, 'email', array('size' => 60, 'maxlength' => 200)); ?></div>
        <div class="formfielderror"><?php echo $form->error($model, 'email'); ?></div>
    </div>
    
    <div class="row">
        <div class="leftformcolum"><?php echo CHtml::label('Password', 'password'); ?></div>
        <div class="rightformcolum"><?php echo CHtml::passwordField('password'); ?></div>
    </div>
    
    <div class="row">
        <div class="leftformcolum"><?php echo CHtml::label('Repeat Password', 'passwordmatch'); ?></div>
        <div class="rightformcolum"><?php echo CHtml::passwordField('password'); ?></div>
    </div>

    <div class="row">
        <div class="leftformcolum"><?php echo $form->labelEx($model, 'emailVisibility'); ?></div>
        <div class="rightformcolum"><?php echo $form->dropDownList($model, 'emailVisibility', array('Only administrators', 'Everyone')); ?></div>
        <div class="formfielderror"><?php echo $form->error($model, 'emailVisibility'); ?></div>
    </div>

    <div class="row">
        <div class="leftformcolum"><?php echo $form->labelEx($model, 'acceptMessages'); ?></div>
        <div class="rightformcolum"><?php
        echo $form->dropDownList($model, 'acceptMessages', array(
            'Don\'t send me e-mails', 'Only from administrators', 'Everyone can send me an e-mail'
        ));
        ?></div>
        <div class="formfielderror"><?php echo $form->error($model, 'acceptMessages'); ?></div>
    </div>

    <div class="row buttons">
        <?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
    </div>

    <?php $this->endWidget(); ?>

</div><!-- form -->