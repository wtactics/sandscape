<?php

use yii\helpers\Html;
use yii\helpers\Url;
//-
use app\assets\GameBundle;

/* @var $this yii\web\View */
/* @var $content string */
/* @var $user yii\web\User */

GameBundle::register($this);

$user = Yii::$app->user;

$this->beginPage();
//TODO: sandscape.initBoard();
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

        <?= Html::csrfMetaTags() ?>

        <title><?= Html::encode($this->title) ?></title>

        <?php $this->head() ?>
    </head>

    <body>
        <?php $this->beginBody() ?>

        <?php echo $content; ?>

        <?php $this->endBody() ?>
    </body>
</html>
<?php
$this->endPage();
