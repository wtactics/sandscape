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
        <meta charset="UTF-8">
        <!-- blueprint css -->
        <link href="_resources/css/blueprint/screen.css" rel="stylesheet" type="text/css" media="screen, projection" />
        <link href="_resources/css/blueprint/print.css" rel="stylesheet" type="text/css" media="print" />
        <!--[if lt IE 8]>
        <link href="_resources/css/blueprint/ie.css" rel="stylesheet" type="text/css" media="screen, projection" />
        <![endif]-->

        <!-- css -->
        <link href="_resources/css/sandscape/main<?php echo (YII_DEBUG ? '' : '.min'); ?>.css" rel="stylesheet" type="text/css" media="screen, projection" />

        <title><?php echo $this->title; ?></title>
    </head>
    <body>
        <div class="container">
            <h1 id="header">Sandscape</h1>
            <div class="span-22 prepend-1 append-1 last" id="menu">
                <?php $this->widget('zii.widgets.CMenu', array('items' => $this->menu, 'encodeLabel' => false)); ?>
            </div>
            <div class="span-22 prepend-1 append-1 last">
                <?php echo $content; ?>
            </div>
            <div class="span-24" id="footer">
                &copy; <?php echo date('Y'); ?>
                &nbsp;<a href="http://sourceforge.net/projects/sandscape">Sandscape</a>
                &nbsp;&amp;&nbsp;
                <a href="http://www.wtactics.org">WTactics.org</a> Team
                &nbsp;|&nbsp;<a href="<?php echo $this->createUrl('site/attribution'); ?>">Attribution</a>
                &nbsp;|&nbsp;Running <em>Sandscape Soulharvester</em>
                <span id="server-time"><?php echo date('Y-m-d H:i:s'); ?></span>
            </div>
        </div>
    </body>
</html>