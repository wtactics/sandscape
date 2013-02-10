<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <title>Chatty</title>
        <link type="text/css" rel="stylesheet" href="css.css" />
        <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.4.4/jquery.min.js"></script>
        <script type="text/javascript">
            $(document).ready(function(){
                reload();
                
                $("#send").click(function(){
                    var msg = $("#text").val();
                    $.post("post.php", {message: msg});
                    $("#text").val("");
                    return false;
                });

                setInterval(reload, 3000);
            });

            var last = 0;
            function reload() {
                $.get('update.php', {after: last}, function(e) {
                    for(i = 0; i < e.length; i++) {
                        //alert(e[i].messageId);
                        $("#chat").append('<br /><strong>&lt;</strong>' + e[i].stamp +
                            '<strong>&gt;:</strong>' + e[i].message);

                        //just a spike...
                        last = e[i].messageId;
                    }
                }, 'json');
            }
        </script>
    </head>

    <body>
        <div id="wrapper">
            <p>&nbsp;</p>
            <div id="chat"></div>

            <div id="message">
                <input name="text" type="text" id="text" size="63" />
                <input name="send" type="submit"  id="send" value="Send" />
            </div>
        </div>
    </body>
</html>