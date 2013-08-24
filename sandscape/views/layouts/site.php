<!DOCTYPE HTML>
<html>
    <head>
        <meta charset="UTF-8">

        <?php
        $url = Yii::app()->baseUrl;
        if (defined('YII_DEBUG') && YII_DEBUG) {
            ?>
            <link href="<?php echo $url; ?>/css/main.css" rel="stylesheet" type="text/css" />
        <?php } else { ?>
            <link href="<?php echo $url; ?>/css/sandscape.all.min.css" rel="stylesheet" type="text/css" />
        <?php } ?>
        <link rel="stylesheet" type="text/css" href="<?php echo $url; ?>/css/libraries/jquery-ui-custom-min.css" />

        <script src="<?php echo $url; ?>/js/libraries/jquery-2.0.3.min.js"></script>
        <script src="<?php echo $url; ?>/js/libraries/jquery-ui-min.js"></script>
        <script src="<?php echo $url; ?>/js/libraries/json3-3.2.5.min.js"></script>
        <script src="<?php echo $url; ?>/js/libraries/underscore-1.5.1.min.js"></script>
        <script src="<?php echo $url; ?>/js/libraries/backbone-1.0.0.min.js"></script>

        <?php if (!defined('YII_DEBUG') || !YII_DEBUG) { ?>
            <script src="<?php echo $url; ?>/js/sandscape.all.min.js"></script>
        <?php } ?>

        <title><?php echo CHtml::encode($this->title); ?></title>
    </head>
    <body>
        <nav id="navigation">
            <?php
            $this->widget('bootstrap.widgets.TbNavbar', array(
                'type' => 'inverse',
                'collapse' => true,
                'items' => $this->menu
            ));
            ?>
        </nav>

        <div id="content">
            <?php echo $content; ?>
        </div>

        <footer id="foot"></footer>
    </body>
</html>