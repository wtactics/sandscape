<?php

/**
 * Bootstrap file is used to setup basic path alias that provide the full path 
 * to the various app's folders, main installation folder and public 
 * (web accessible) and card's upload folder.
 * 
 * NOTE: Usually, there is no need to update this file, if needed, please 
 * override any of these paths in the local config file.
 */
Yii::setAlias('@container', realpath(__DIR__ . '/../../'));
//
Yii::setAlias('@platform', realpath(__DIR__ . '/../../@platform'));
Yii::setAlias('@common', realpath(__DIR__ . '/../../common'));
Yii::setAlias('@console', realpath(__DIR__ . '/../../console'));
Yii::setAlias('game', realpath(__DIR__ . '/../../game'));
Yii::setAlias('@uploads', realpath(__DIR__ . '/../../../web/data'));
