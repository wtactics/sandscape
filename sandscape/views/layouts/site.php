<!DOCTYPE HTML>
<html>
    <head>
        <meta charset="UTF-8">

        <?php
        $url = Yii::app()->baseUrl;
        if (YII_DEBUG) {
            ?>
            <link href="<?php echo $url; ?>/css/development/main.css" rel="stylesheet" type="text/css" />
        <?php } else { ?>
            <link href="<?php echo $url; ?>/css/sandscape.all.min.css" rel="stylesheet" type="text/css" />
        <?php } ?>
        <link rel="stylesheet" type="text/css" href="<?php echo $url; ?>/css/libraries/jquery-ui-custom-min.css" />

        <script type="text/javascript" src="<?php echo $url; ?>/js/libraries/jquery-min.js"></script>
        <script type="text/javascript" src="<?php echo $url; ?>/js/libraries/jquery-ui-min.js"></script>

        <?php if (YII_DEBUG) { ?>
            <script type="text/javascript" src="<?php echo $url; ?>/js/sandscape.all.min.js"></script>
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