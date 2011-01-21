<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <title>Drag spike</title>
        <link type="text/css" rel="stylesheet" href="css.css" />
        <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.4.4/jquery.min.js"></script>
        <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.9/jquery-ui.min.js"></script>
        <script type="text/javascript">
            $(function() {
                $( ".drags" ).draggable({
                    drag: function(event, ui) {
                    }
                });
                
                $( ".cards" ).droppable({
                    drop: function(event, ui) {
                        $(this).parent().append($(ui.draggable));
                        $(ui.draggable).css('left', -100);
                        $(ui.draggable).css('top', $(this).parent().css('top'));
                        $(this).droppable('droppable', false);
                    }
                });
            });
        </script>
        <style type="text/css">
            .drags {
                width: 116px;
                height: 161px;
            }
        </style>
    </head>

    <body>
        <p id="stats"></p>

        <span class="drags"><img src="DonationsforRecovery.png" class="cards" name="1"/></span>
        <span class="drags"><img src="DoubttheViolence.png" class="cards" name="2"/></span>
        <span class="drags"><img src="ElvishArcher.png" class="cards" name="3"/></span>
        <span class="drags"><img src="ElvishFighter.png" class="cards" name="4"/></span>
        <span class="drags"><img src="ElvishMarksman.png" class="cards" name="5"/></span>
    </body>
</html>
