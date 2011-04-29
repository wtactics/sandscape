<?php
/*
 * _newGameDlg.php
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
?><?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'newgamedlg',
    // additional javascript options for the dialog plugin
    'options' => array(
        'title' => 'New Game',
        'autoOpen' => false,
        'modal' => true,
        'buttons' => array(
            'Create' => 'js:addGame',
            'Cancel' => 'js:function(){ $(this).dialog("close");}',
        ),
        'width' => '400px'
    )
));
?>

<div class="form">

    <?php
    $form = $this->beginWidget('CActiveForm', array(
                'id' => 'newgame-form',
                'enableAjaxValidation' => false,
            ));
    ?>
    <table width="100%">

        <tr>
            <td><?php echo CHtml::label('Private game?', 'private'); ?></td>
            <td><?php echo CHtml::checkBox('private'); ?></td>
        </tr>
        <tr>
            <td><?php echo CHtml::label('Decks', 'deck'); ?></td>
            <td><?php echo CHtml::dropDownList('deck', '', CHtml::listData($decks, 'deckId', 'name')); ?></td>
        </tr>
    </table>
        <?php
        echo CHtml::hiddenField('action', $this->createUrl('/lobby/create'), array('id' => 'action'));

        $this->endWidget();
        ?>

</div><!-- form -->

<?php $this->endWidget('zii.widgets.jui.CJuiDialog'); ?>