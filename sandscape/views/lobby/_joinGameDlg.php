<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'joindlg',
    // additional javascript options for the dialog plugin
    'options' => array(
        'title' => 'Join Game',
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