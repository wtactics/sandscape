<?php
$this->title = 'Decks';

Yii::app()->clientScript->registerCssFile('_resources/css/sandscape/modal.css');
Yii::app()->clientScript->registerScriptFile('_resources/js/thirdparty/jquery.simplemodal.1.4.1.min.js');
?>
<h2>Manage Decks</h2>
<div class="span-22 last">
    <a href="<?php echo $this->createURL('create'); ?>">New Deck</a>
    &nbsp;:&nbsp;
    <a href="javascript:;" onclick="$('#precons').modal();">Pre-cons</a>
</div>
<?php
$this->widget('zii.widgets.grid.CGridView', array(
    'id' => 'deck-grid',
    'dataProvider' => $filter->search(Yii::app()->user->id),
    'filter' => $filter,
    'columns' => array(
        'name',
        array(
            'name' => 'created',
            'type' => 'date',
            'value' => 'strtotime($data->created)',
            'filter' => false
        ),
        array(
            'header' => 'Actions',
            'class' => 'CButtonColumn'
        )
    )
));
?>
<div style="display: none">
    <div id="precons">
        <?php echo CHtml::form($this->createURL('deck/fromtemplate')); ?>
        <h2>Pre-constructed Decks</h2>
        <p>
            <?php echo CHtml::label('Available Decks', 'preconslst'), '<br />', CHtml::dropDownList('preconslst', null, CHtml::listData($templates, 'deckTemplateId', 'name')); ?>
        </p>
        <p>
            <?php echo CHtml::submitButton('Create', array('class' => 'button')); ?>
        </p>
        <?php echo CHtml::endForm(); ?>
    </div>
</div>
