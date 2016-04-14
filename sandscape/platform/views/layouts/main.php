<?php

use yii\helpers\Html;
use yii\helpers\Url;
//-
use app\assets\PlatformBundle;

/* @var $this yii\web\View */
/* @var $content string */
/* @var $user yii\web\User */
/* @var $tab string */

\app\assets\PlatformBundle::register($this);

$user = Yii::$app->user;
$tab = isset($this->params['tab']) ? $this->params['tab'] : null;

$this->beginPage();
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

    <body class="skin-red">
        <?php $this->beginBody() ?>

        <div id="top-nav" class="navbar navbar-inverse navbar-static-top">
            <div class="container-fluid">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="#">Sandscape</a>
                </div>
                <div class="navbar-collapse collapse">
                    <ul class="nav navbar-nav navbar-right">
                        <li class="dropdown">
                            <a class="dropdown-toggle" role="button" data-toggle="dropdown" href="#"><i class=""></i> user name <span class="caret"></span></a>
                            <ul id="g-account-menu" class="dropdown-menu" role="menu">
                                <li><a href="#">Decks</a></li>
                                <li><a href="#">Profile</a></li>
                                <li><a href="#">Logout</a></li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-3">
                    <a href="#"><strong><i class=""></i> MENU</strong></a>
                    <hr />

                    <ul class="nav nav-stacked">
                        <li class="nav-header"></a>
                        <li class="active"> <a href="#"><i class=""></i> Dashboard</a></li>
                        <li><a href="#"><i class=""></i> Cards</span></a></li>
                        <li><a href="#"><i class=""></i> Decks</a></li>
                        <li><a href="#"><i class=""></i> Lobby</a></li>
                    </ul>
                </div>

                <div class="col-sm-9">
                    <?= $content ?>
                </div>
            </div>
        </div>

        <footer class="text-center"><?= date('Y') ?> &copy; WTactics project - <a href="http://wtactics.org">wtactics.org</a></footer>

        <?php $this->endBody() ?>
    </body>
</html>
<?php
$this->endPage();
