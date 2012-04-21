<div id="lobbytools">
    <div id="messagetools">
        <input type="text" class="text" id="writemessage" />

        <button type="button" class="button" onclick="sendMessage();" id="sendbtn">Send</button>
    </div>
    <div id="gametools">
        <?php if ($cardCount != 0) { ?>
            <a href="javascript:;" onclick="$('#createdlg').modal();" class="button">Create Game</a>

            <?php
            echo CHtml::label('Filter Games:', 'filterGames'), '&nbsp;&nbsp;&nbsp;',
            CHtml::dropDownList('filterGames', null, array(
                0 => 'All',
                1 => 'Paused',
                2 => 'Running',
                3 => 'That I play',
                4 => 'Waiting for me',
                5 => 'Waiting for opponent'
                    ), array('onchange' => 'filterGameList();')
            );
        }
        ?>
    </div>
    <div class="clearfix"></div>
</div>