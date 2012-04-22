<?php
$this->title = 'Decks';

Yii::app()->clientScript->registerCssFile('_resources/css/sandscape/modal' . (YII_DEBUG ? '' : '.min') . '.css');
Yii::app()->clientScript->registerScriptFile('_resources/js/thirdparty/jquery.simplemodal.1.4.1.min.js');
?>

<h2>Manage Decks</h2>
<?php if ($cardCount == 0) { ?>
    <div style="text-align: center">There are no cards in the system, you can't create any decks.</div>
<?php } else { ?>
    <div class="list-tools">
        <a href="<?php echo $this->createURL('create'); ?>">Create Deck</a>
        <?php if (count($templates) > 0) { ?>
            <!-- //TODO: reactivate <a href="javascript:;" onclick="$('#precons').modal();">Pre-constructed Decks</a> -->
        <?php } ?>
    </div>
    <?php
    $this->widget('zii.widgets.grid.CGridView', array(
        'id' => 'deck-grid',
        'dataProvider' => $filter->search(Yii::app()->user->id),
        'filter' => $filter,
        'columns' => array(
            array(
                'name' => 'name',
                'type' => 'html',
                'value' => 'CHtml::link($data->name, Yii::app()->createUrl("decks/update", array("id" => $data->deckId)))'
            ),
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
        ),
        'template' => '{items} {pager} {summary}'
    ));

    if (count($templates) > 0) {
        ?>
        <div style="display: none">
            <div id="precons">
                <?php echo CHtml::form($this->createURL('deck/fromtemplate')); ?>
                <h2>Pre-constructed Decks</h2>
                <p>
                    <?php
                    echo CHtml::label('Available Decks', 'preconslst'), '<br />',
                    CHtml::dropDownList('preconslst', null, CHtml::listData($templates, 'deckTemplateId', 'name'));
                    ?>
                </p>
                <p>
                    <?php echo CHtml::submitButton('Create', array('class' => 'button')); ?>
                </p>
                <?php echo CHtml::endForm(); ?>
            </div>
        </div>
        <?php
    }
}?>