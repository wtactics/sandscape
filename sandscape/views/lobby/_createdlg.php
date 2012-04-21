<div id="createdlg" class="lobbydlg">
    <h2>Create a New Game</h2>

    <?php echo CHtml::beginForm($this->createURL('lobby/create')); ?>  

    <div class="lobbydlg-left">
        <fieldset>
            <legend>Deck Options</legend>

            <?php
            if ($fixDeckNr) {
                echo CHtml::hiddenField('maxDecks', $decksPerGame);
            } else {
                ?>
                <div class="dlgrow">
                    <?php
                    echo CHtml::label('Number of Decks:', 'maxDecks'),
                    CHtml::textField('maxDecks', $decksPerGame, array(
                        'size' => 4,
                        'onchange' => 'limitDeckSelection("#btnCreate")'
                    ));
                    ?>
                </div>
            <?php } ?>

            <div class="dlgrow">
                <?php
                echo CHtml::label('Available Decks:', 'deckList'),
                CHtml::checkBoxList('deckList', array(), CHtml::listData($decks, 'deckId', 'name'), array(
                    'class' => 'marker',
                    'onchange' => 'limitDeckSelection("#btnCreate")'
                ));
                ?>
            </div>

            <div class="dlgrow">
                <?php
                echo CHtml::label('Use Graveyard?', 'useGraveyard'),
                CHtml::checkBox('useGraveyard', true, array('value' => 1));
                ?>
            </div>
        </fieldset>
    </div>

    <div class="lobbydlg-right">
        <fieldset>
            <legend>General Options</legend>
            <div class="dlgrow">
                <?php
                echo CHtml::label('Spectators can:', 'gameChatSpectators'),
                CHtml::dropDownList('gameChatSpectators', 0, array(0 => 'Be quiet', 1 => 'Speak in chat'));
                ?>
            </div>

            <div class="dlgrow">
                <?php
                echo CHtml::label('Limit opponent to:', 'limitOpponent');

                $this->widget('zii.widgets.jui.CJuiAutoComplete', array(
                    'name' => 'limitOpponent',
                    'sourceUrl' => "{$this->createUrl('lobby/ajaxusercomplete')}",
                    'options' => array(
                        'minLength' => '2',
                    )
                ));
                ?>
            </div>
        </fieldset>
    </div>
    <div class="clearfix"></div>

    <div class="dlgbuttons">
        <?php
        echo CHtml::submitButton('I\'m Ready!', array(
            'name' => 'CreateGame',
            'id' => 'btnCreate',
            'disabled' => 'disabled',
            'class' => 'button'
        )),
        CHtml::link('Cancel', 'javascript:;', array('class' => 'simplemodal-close'));
        ?>
    </div>
    <?php echo CHtml::endForm(); ?>
</div>
