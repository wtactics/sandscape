<?php $this->title = 'Game Information [ ' . $game->gameId . ' ]'; ?>

<h2><?php echo $this->title ?></h2>

<table>
    <tr>
        <td>Player 1:</td>
        <td>
            <?php
            echo CHtml::image('_resources/images/' .
                    ($game->player1Ready ? 'icon-x16-tick-circle.png' : 'icon-x16-cross.png'), ''
                    , array('title' => ($game->player1Ready ? 'Ready' : 'Not ready'))),
            CHtml::link($game->creator->name, $this->createUrl('account/profile'
                            , array('id' => $game->player1))
            );
            ?>
        </td>
    </tr>
    <tr>
        <td>Player 2:</td>
        <td>
            <?php
            if ($game->player2) {
                echo CHtml::image('_resources/images/' .
                        ($game->player2Ready ? 'icon-x16-tick-circle.png' : 'icon-x16-cross.png')
                        , '', array('title' => ($game->player2Ready ? 'Ready' : 'Not ready'))),
                CHtml::link($game->opponent->name, $this->createUrl('account/profile'
                                , array('id' => $game->player2))
                );
            } else {
                ?>
                No opponent yet.
            <?php } ?>
        </td>
    </tr>
    <?php if ($game->winnerId) { ?>
        <tr>
            <td>Winner was:</td>
            <td><?php echo $game->winner->name; ?></td>
        </tr>
    <?php } ?>
    <tr>
        <td>Created at:</td>
        <td><?php echo $game->created; ?></td>
    </tr>
    <?php if ($game->started) { ?>
        <tr>
            <td>Started at:</td>
            <td><?php echo $game->started; ?></td>
        </tr>
    <?php } ?>
    <tr>
        <td>Game status:</td>
        <td><?php echo ($game->running ? 'Running' : ($game->paused ? 'Paused' : ($game->ended ? 'Finished' : 'Unknown'))); ?></td>
    </tr>
    <tr>
        <td>Extra:</td>
        <td>
            Using <?php echo $game->maxDecks; ?> deck(s)<?php echo ($game->graveyard ? ' and graveyard' : ''); ?>.<br />
            <?php if ($game->ended || !$game->started || ($game->running || $game->paused)) { ?>
                Spectators are able to speak in game chat.
            <?php } else if ($game->ended) { ?>
                Spectators were able to speak in game chat.
            <?php } ?>
        </td>
    </tr>
</table>

<h3>Own Decks</h3>
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

echo CHtml::textArea('notes'),
 CHtml::hiddenField('dlgGameId'),
 CHtml::hiddenField('dlgDeckId');

$this->endWidget('zii.widgets.jui.CJuiDialog');
