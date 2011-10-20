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

        <title></title>
    </head>
    <body>
        <div class="container">
            <h1 id="header">Sandscape</h1>
            <div class="span-24" id="menu">
                <?php $this->widget('zii.widgets.CMenu', array('items' => $this->menu)); ?>
            </div>
            <?php echo $content; ?>
            <div class="span-24" id="footer">
                &copy; <?php echo date('Y'); ?> <a href="#">Sandscape</a> & <a href="#">WTactics</a> Team
            </div>
        </div>
    </body>
</html>