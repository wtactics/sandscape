<!DOCTYPE HTML>
<html>
    <head>
        <meta charset="UTF-8">
        <link href="<?php echo Yii::app()->baseUrl; ?>/_resources/css/sandscape/main<?php echo (YII_DEBUG ? '' : '.min'); ?>.css" rel="stylesheet" type="text/css" media="screen, projection" />

        <title><?php echo $this->title; ?></title>
    </head>
    <body>
        <div id="header">
            <h1><a href="<?php echo Yii::app()->baseUrl; ?>">Sandscape</a></h1>
            <div id="">
                <div id=""></div>
                <div id="menu">
                    <?php $this->widget('zii.widgets.CMenu', array('items' => $this->menu, 'encodeLabel' => false)); ?>
                    <div class="clearfix"></div>
                </div>
            </div>
        </div>

        <div id="content">
            <?php echo $content; ?>
        </div>

        <div id="footer">
            <div>
                <ul>
                    <li><a href="<?php echo $this->createUrl('site/attribution'); ?>">Attribution</a></li>
                    <li><a href="http://www.wtactics.org">WTactics.org</a></li>
                    <li><a href="http://sourceforge.net/projects/sandscape">Sandscape</a></li>
                </ul>
            </div>
            <div>
                <ul>
                    <li>Running Serenity</li>
            </div>
            <div class="clearfix"></div>
        </div>
    </body>
</html>