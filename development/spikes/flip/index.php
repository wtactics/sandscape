<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <title>Flipping &amp; Pile</title>
        <link type="text/css" rel="stylesheet" href="css.css" />

        <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.4.4/jquery.min.js"></script>
        <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.9/jquery-ui.min.js"></script>
        <script type="text/javascript">
            $(function() {
                $('#hand').droppable({
                    accept: "#hdeck",
                    drop: function( event, ui ) {
                        var novo = $(ui.helper).clone(false);
                        novo.removeClass('box ui-draggable ui-draggable-dragging deckorigin');
                        novo.attr('src',  $('#hdeck').attr('src'));
                        novo.attr('id', '');
                        novo.css('position', 'static');
                        novo.css('left', '0');
                        novo.css('top', '0');
                        $('#hand').append(novo);

                        //ui.helper.draggable('disable');
                        ui.helper.attr('src', '');
                        ui.helper.css('visibility', 'hidden');
                        ui.helper.css('position', '-120px');
                    }
                });

                $( "#deck" ).click(function() {
                    $.get('random.php', function(e) {
                        $('#hdeck').attr('src', '../card-images/' + e);
                        $('#hdeck').css('visibility', 'visible');
                    });
                });

                $('#hdeck').draggable({revert: true});
            });
        </script>

        <style type="text/css">
            .deckorigin {
                position: relative;
                left: -120px;
                visibility: hidden;
            }
        </style>
    </head>

    <body>
        <table width="100%" border="1">
            <tr>
                <td width="20%" align="center">
                    <div id="hand" style="width: 200px; height: 200px; background-color: red;">

                    </div>
                </td>
                <td align="center">empty area</td>
                <td width="20%">
                    <span>
                        <img id="deck" src="../card-images/DonationsforRecovery.png" style="position: relative; left: 0;"/>
                        <img id="hdeck" src="" class="deckorigin"/>
                    </span>
                </td>
            </tr>
        </table>
    </body>
</html>