<div id="createdlg">
    <?php echo CHtml::beginForm($this->createURL('lobby/create')); ?>
    <h2>Create Game</h2>
    <div class="lobby-dlg-left success">
        <h3>Deck Options</h3>
        <?php
        if ($fixDeckNr) {
            echo CHtml::hiddenField('maxDecks', $decksPerGame);
        } else {
            ?>
            <p>
                <?php
                echo CHtml::label('Number of Decks:', 'maxDecks'),
                CHtml::textField('maxDecks', $decksPerGame, array(
                    'size' => 4,
                    'onchange' => 'limitDeckSelection("#btnCreate")'
                ));
                ?>
            </p>
        <?php } ?>
        <p class="deck-list">
            <?php
            echo CHtml::label('Available Decks:', 'deckList'),
            CHtml::checkBoxList('deckList', array(), CHtml::listData($decks, 'deckId', 'name'), array(
                'class' => 'marker',
                'onchange' => 'limitDeckSelection("#btnCreate")'
            ));
            ?>
        </p>
        <p>
            <?php
            echo CHtml::checkBox('useGraveyard', true, array('value' => 1)),
            CHtml::label('Use Graveyard?', 'useGraveyard');
            ?>
        </p>
    </div>
    <div class="lobby-dlg-right info">
        <h3>General Options</h3>
        <p>
            <?php
            echo CHtml::label('Spectators can:', 'gameChatSpectators'),
            CHtml::dropDownList('gameChatSpectators', 0, array(0 => 'Be quiet', 1 => 'Speak in chat'));
            ?>
        </p>
        <p>
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

    <div class="clearfix"></div>

    <p>
        <?php
        echo CHtml::submitButton('I\'m Ready!', array(
            'name' => 'CreateGame',
            'id' => 'btnCreate',
            'disabled' => 'disabled',
            'class' => 'button'
        )),
        CHtml::link('Cancel', 'javascript:;', array('class' => 'simplemodal-close'));
        ?>
    </p>
    <?php echo CHtml::endForm(); ?>
</div>
