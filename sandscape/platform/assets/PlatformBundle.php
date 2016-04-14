<?php

/*
 * PlatformBundle.php
 * 
 * PGESPRO, Plataforma de gestão de processos de insolvência, falência e processos 
 * particulares de venda de bens. Sistema de apoio ao modelo de negócio da 
 * Lusoparticipações Avalibérica, S.A. (e empresas do grupo) e aos procedimentos 
 * administrativos aplicados a processos e vendas.
 * 
 * (C) 2012 - 2016, Lusoparticipações Avalibérica, S.A.
 */

namespace app\assets;

use yii\web\AssetBundle;

/**
 * @author Sérgio Lopes <sergio.lopes@avaliberica.pt>
 * @copyright (c) 2016, Lusoparticipações Avalibérica, S.A.
 */
class PlatformBundle extends AssetBundle {

    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css'
    ];
    public $js = [
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\web\JqueryAsset',
        'yii\bootstrap\BootstrapAsset',
        'yii\bootstrap\BootstrapPluginAsset'
    ];

    public function __construct($config = []) {
        if (defined('YII_ENV') && YII_ENV == 'dev') {
            $this->js[] = 'js/scripts.js';
            $this->css[] = 'css/styles.css';
        } else {
            $this->js[] = 'js/scripts.min.js';
            $this->css[] = 'css/styles.min.css';
        }

        parent::__construct($config);
    }

}
