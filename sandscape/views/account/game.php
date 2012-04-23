<?php $this->title = 'Game Information [ ' . $game->gameId . ' ]'; ?>

<h2><?php echo $this->title ?></h2>

<?php
$data = array(
    'player1' => $game->creator,
    'player2' => $game->opponent,
    'winner' => $game->winner,
    'created' => $game->created,
    'started' => $game->started,
    'status' => ($game->running ? 'Running' : ($game->paused ? 'Paused' : ($game->ended ? 'Finished' : 'Unknown'))),
    'extra' => 'Using ' . $game->maxDecks . 'deck(s)' . ($game->graveyard ? ' and graveyard' : '') . '.'
);

$this->widget('zii.widgets.CDetailView', array(
    'data' => $data,
    'attributes' => array(
        array(
            'name' => 'player1',
            'label' => 'Player 1',
            'type' => 'raw',
            'value' => CHtml::link($game->creator->name, $this->createUrl('account/profile', array('id' => $game->player1)))
        ),
        array(
            'name' => 'player2',
            'label' => 'Player 2',
            'type' => 'raw',
            'value' => CHtml::link($game->opponent->name, $this->createUrl('account/profile', array('id' => $game->player2)))
        ),
        'created',
        'started',
        'status',
        array(
            'name' => 'winner',
            'label' => 'Winner',
            'type' => 'raw',
            'value' => CHtml::link($game->winner->name, $this->createUrl('account/profile', array('id' => $game->winnerId)))
        ),
        array(
            'name' => 'extra',
            'label' => 'Extra'
        )
    )
));
?>

<?php if ($game->ended) { ?>
    <h3>Decks</h3>
    <table>
        <?php
        $url = $this->createUrl('account/starratingajax');
        $url2 = $this->createUrl('account/notesajax');

        foreach ($decks as $entry) {
            $deck = $entry['deck'];
            $stats = $entry['stats'];
            ?>
            <tr>
                <td><?php echo CHtml::link($deck->name, $this->createUrl('decks/view', array('id' => $deck->deckId))); ?></td>
                <td><?php echo count($deck->deckCards); ?> cards</td>
                <td>
                    <?php
                    $this->widget('CStarRating', array(
                        'name' => 'rating',
                        'minRating' => 1,
                        'maxRating' => 7,
                        'starCount' => 7,
                        'callback' => "function() {
                            $.ajax({
                                type: 'POST',
                                url: '{$url}',
                                data: {
                                    rate: $(this).val(),
                                    game: {$game->gameId},
                                    deck: {$deck->deckId}
                                }
                            })
                        }"
                    ));
                    ?>
                </td>
                <td>
                    <?php
                    echo CHtml::link(
                            CHtml::image('_resources/images/icon-x16-document-pencil.png', '', array('title' => 'Edit notes'))
                            , 'javascript:;', array(
                        'onclick' => "$('#dlgGameId').val({$game->gameId});$('#dlgDeckId').val({$deck->deckId});$('#notesDlg').dialog('open');"
                    ));
                    ?>
                </td>
            </tr>
        <?php } ?>
    </table>

    <?php
    $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
        'id' => 'notesDlg',
        'options' => array(
            'title' => 'Notes',
            'autoOpen' => false,
            'height' => 390,
            'width' => 440,
            'buttons' => array(
                'Save' => "js:function() {
                    $.ajax({
                        type: 'POST',
                        url: '{$url2}',
                        data: {
                            notes: $('#notes').val(),
                            game: $('#dlgGameId').val(),
                            deck: $('#dlgDeckId').val()
                        }
                    });
                    $(this).dialog('close');
                }",
                'Cancel' => 'js: function() { $(this).dialog("close"); }'
            )
        )
    ));

    echo CHtml::textArea('notes', null, array('style' => 'width: 95%;height:90%;')),
    CHtml::hiddenField('dlgGameId'),
    CHtml::hiddenField('dlgDeckId');

    $this->endWidget('zii.widgets.jui.CJuiDialog');
}