<?php
/*
 * views/cards/_search.php
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
?><div class="wide form">

    <?php
    $form = $this->beginWidget('CActiveForm', array(
                'action' => Yii::app()->createUrl($this->route),
                'method' => 'get',
            ));
    ?>

    <div class="row">
        <div class="leftformcolum"><?php echo $form->label($model, 'faction'); ?></div>
        <div class="rightformcolum"><?php echo $form->textField($model, 'faction', array('size' => 60, 'maxlength' => 150)); ?></div>
        <div class="clear"></div>
    </div>

    <div class="row">
        <div class="leftformcolum"><?php echo $form->label($model, 'type'); ?></div>
        <div class="rightformcolum"><?php echo $form->textField($model, 'type', array('size' => 60, 'maxlength' => 150)); ?></div>
        <div class="clear"></div>
    </div>

    <div class="row">
        <div class="leftformcolum"><?php echo $form->label($model, 'subtype'); ?></div>
        <div class="rightformcolum"><?php echo $form->textField($model, 'subtype', array('size' => 60, 'maxlength' => 150)); ?></div>
        <div class="clear"></div>
    </div>

    <div class="row">
        <div class="leftformcolum"><?php echo $form->label($model, 'cost'); ?></div>
        <div class="rightformcolum"><?php echo $form->textField($model, 'cost'); ?></div>
        <div class="clear"></div>
    </div>

    <div class="row">
        <div class="leftformcolum"><?php echo $form->label($model, 'threshold'); ?></div>
        <div class="rightformcolum"><?php echo $form->textField($model, 'threshold', array('size' => 60, 'maxlength' => 100)); ?></div>
        <div class="clear"></div>
    </div>

    <div class="row">
        <div class="leftformcolum"><?php echo $form->label($model, 'attack'); ?></div>
        <div class="rightformcolum"><?php echo $form->textField($model, 'attack'); ?></div>
        <div class="clear"></div>
    </div>

    <div class="row">
        <div class="leftformcolum"><?php echo $form->label($model, 'defense'); ?></div>
        <div class="rightformcolum"><?php echo $form->textField($model, 'defense'); ?></div>
        <div class="clear"></div>
    </div>

    <div class="row">
        <div class="leftformcolum"><?php echo $form->label($model, 'rules'); ?></div>
        <div class="rightformcolum"><?php echo $form->textField($model, 'rules', array('size' => 60, 'maxlength' => 255)); ?></div>
        <div class="clear"></div>
    </div>

    <div class="row">
        <div class="leftformcolum"><?php echo $form->label($model, 'author'); ?></div>
        <div class="rightformcolum"><?php echo $form->textField($model, 'author', array('size' => 60, 'maxlength' => 100)); ?></div>
        <div class="clear"></div>
    </div>

    <div class="row">
        <div class="leftformcolum"><?php echo $form->label($model, 'revision'); ?></div>
        <div class="rightformcolum"><?php echo $form->textField($model, 'revision'); ?></div>
        <div class="clear"></div>
    </div>

    <div class="row buttons">
        <?php echo CHtml::submitButton('Search'); ?>
    </div>

    <?php $this->endWidget(); ?>

</div>
<!-- search-form -->