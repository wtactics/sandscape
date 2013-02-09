<?php
$this->title = Yii::t('interface', 'Lobby');

if (YII_DEBUG) {
    Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/css/lobby.css');
    Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/lobby.js');
}

$this->renderPartial('_users', array('users' => $users));

$this->renderPartial('_messages', array('messages' => $messages));

$this->renderPartial('_games', array('games' => $games))
?>

<div class="clearfix"></div>

<div>
    <?php
    $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
        'id' => 'chatis',
        'type' => 'inline',
        'htmlOptions' => array('class' => 'well'),
            ));

    $chatForm = new ChatForm();
    echo $form->textFieldRow($chatForm, 'text');

    $this->widget('bootstrap.widgets.TbButton', array(
        'buttonType' => 'submit',
        'label' => Yii::t('interface', 'Send')
    ));

    $this->widget('bootstrap.widgets.TbButton', array(
        'label' => Yii::t('interface', 'New Game'),
        'type' => 'primary',
        'htmlOptions' => array(
            'class' => 'pull-right',
            'data-toggle' => 'modal',
            'data-target' => '#createdlg',
        ),
    ));

    $this->endWidget();
    ?>
</div>

<?php
$this->renderPartial('_createdlg');
