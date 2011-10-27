<?php
Yii::app()->clientScript->registerScript('menuhover', "
        $('#menu > ul li').hover(function() {
            $(this).addClass('hover');
            $('ul:first', this).css('visibility', 'visible');
        }, function() {
            $(this).removeClass('hover');
            $('ul:first',this).css('visibility', 'hidden');
        });");
?>
<!DOCTYPE HTML>
<html>
    <head>
        <meta charset="UTF-8" />
        <!-- blueprint css -->
        <link href="_resources/css/blueprint/screen.css" rel="stylesheet" type="text/css" media="screen, projection" />
        <link href="_resources/css/blueprint/print.css" rel="stylesheet" type="text/css" media="print" />
        <!--[if lt IE 8]>
        <link href="_resources/css/blueprint/ie.css" rel="stylesheet" type="text/css" media="screen, projection" />
        <![endif]-->

        <!-- css -->
        <link href="_resources/css/main.css" rel="stylesheet" type="text/css" media="screen, projection" />

        <title><?php echo $this->title; ?></title>
    </head>
    <body>
        <div class="container">
            <h1 id="header">Sandscape</h1>
            <div class="span-22 prepend-1 append-1 last" id="menu">
                <?php $this->widget('zii.widgets.CMenu', array('items' => $this->menu)); ?>
            </div>
            <div class="span-22 prepend-1 append-1 last">
                <?php echo $content; ?>
            </div>
            <div class="span-24" id="footer">
                &copy; <?php echo date('Y'); ?> <a href="http://sourceforge.net/projects/sandscape">Sandscape</a> & <a href="http://wtactics.org">WTactics</a> Team
                &nbsp;|&nbsp;Running <em>Sandscape Green Shield</em>
                <span id="server-time" style="float:right">Server time: <?php echo date(DATE_W3C); ?></span>
            </div>
        </div>
    </body>
</html>