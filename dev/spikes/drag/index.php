<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <title>Drag spike</title>
        <link type="text/css" rel="stylesheet" href="css.css" />
        <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.4.4/jquery.min.js"></script>
        <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.9/jquery-ui.min.js"></script>
        <script type="text/javascript">
            $(function() {
                var left = 0;
                var top = 0
                $( ".drags" ).draggable({
                    drag: function(event, ui) {
                        if($(this).data('piled')) {
                            left = parseInt($(this).css('left'), 10);
                            top = parseInt($(this).css('top'), 10);

                            //TOP,RIGH,BOTTOM,LEFT: -170, 10, 170, -240
                            if(left < -240 || left > 10 || top < -170 || top > 170) {
                                //1)remove from parent span
                                //2)if no child spans: active droppable as we may
                                //have been the last in the pile
                                //3)add to body

                                $(this).parent().parent().append($(this));
                                if($(this).children('.drags').length == 0) {
                                    $(this).children('.cards').droppable('droppable', true);
                                }
                                $(this).data('piled', false);
                            }

                            $("#stats").html('LEFT: ' + $(this).css('left') + '&nbsp;/&nbsp;TOP: ' + $(this).css('top'));
                        }
                    }
                });
                
                $( ".cards" ).droppable({
                    drop: function(event, ui) {
                        $(this).parent().append($(ui.draggable));
                        $(ui.draggable).data('piled', true);
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
        <p id="stats">&nbsp;</p>

        <span class="drags"><img src="DonationsforRecovery.png" class="cards" name="1"/></span>
        <span class="drags"><img src="DoubttheViolence.png" class="cards" name="2"/></span>
        <span class="drags"><img src="ElvishArcher.png" class="cards" name="3"/></span>
        <span class="drags"><img src="ElvishFighter.png" class="cards" name="4"/></span>
        <span class="drags"><img src="ElvishMarksman.png" class="cards" name="5"/></span>
    </body>
</html>
