<!DOCTYPE HTML>
<html>
    <head>
        <?php $url = Yii::app()->baseUrl; ?>
        <meta charset="UTF-8">
        <link rel="stylesheet" type="text/css" href="<?php echo $url; ?>/css/libraries/jquery-ui-custom-min.css" />
        
        <script type="text/javascript" src="<?php echo $url; ?>/js/libraries/jquery-min.js"></script>
        <script type="text/javascript" src="<?php echo $url; ?>/js/libraries/jquery-ui-min.js"></script>
        
        <title><?php echo $this->title; ?></title>
    </head>
    <body>
        <div id="game-table">
            <?php echo $content; ?>
        </div>
    </body>
</html>