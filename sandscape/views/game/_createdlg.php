<div id="createdlg">
    <h2>Create Game</h2>
    <?php
    echo CHtml::beginForm($this->createURL('game/create'));
    if ($fixDeckNr) {
        echo CHtml::hiddenField('maxDecks', $decksPerGame);
    } else {
        ?>
        <p>
            <?php
            echo CHtml::label('Number of Decks:', 'maxDecks'), '<br />',
            CHtml::textField('maxDecks', $decksPerGame, array('size' => 4));
            ?>
        </p>
    <?php } ?>
    <p class="deck-list">
        <?php
        echo CHtml::label('Available Decks:', 'deckList'), '<br />',
        CHtml::checkBoxList('deckList', array(), CHtml::listData($decks, 'deckId', 'name'), array(
            'class' => 'marker',
            'onchange' => 'limitDeckSelection("#btnCreate")'
        ));
        ?>
    </p>
    <p>
        <?php
        echo CHtml::checkBox('useGraveyard', true, array('value' => 1)), '&nbsp;',
        CHtml::label('Use Graveyard?', 'useGraveyard');
        ?>
    </p>
    <p>
        <?php
        echo CHtml::label('Spectators can:', 'gamechatspectators'), '<br />',
        CHtml::dropDownList('gamechatspectators', 0, array(0 => 'Be quiet', 1 => 'Speak in chat'));
        ?>
    </p>
    <p>
        <?php
        echo CHtml::submitButton('Ready!', array(
            'name' => 'CreateGame',
            'id' => 'btnCreate',
            'disabled' => 'disabled'
        ));
        ?>
    </p>
    <?php echo CHtml::endForm(); ?>
</div>
