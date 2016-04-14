<?php

/*
 * AssetController.php
 * 
 * This file is part of Sandscape, a virtual, browser based, table allowing
 * people to play a customizable card games (CCG) online.
 *
 * Copyright (c) 2011 - 2016, WTactics Project <http://wtactics.org>
 * 
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Affero General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 * 
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU Affero General Public License for more details.
 * 
 * You should have received a copy of the GNU Affero General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */

namespace app\controllers;

use Yii;

/**
 * //TODO: documentation
 * 
 * @author Sérgio Lopes <knitter.is@gmail.com>
 * @copyright (c) 2016, WTactics Project
 */
class AssetController extends \yii\console\Controller {

    /**
     * @return int
     */
    public function actionIndex() {
        $path = realpath(Yii::getAlias('@container') . '/../') . '/web/frontend';
        $jsContent = '';
        foreach (Yii::$app->params['assets']['js']['merge'] as $merge) {
            $jsContent .= file_get_contents($path . '/' . $merge);
        }

        $cssContent = '';
        foreach (Yii::$app->params['assets']['css']['merge'] as $merge) {
            $cssContent .= file_get_contents($path . '/' . $merge);
        }

        $tmp = '/tmp/minscss.' . time() . '.css';

        $tools = Yii::$app->params['assets']['tools'];
        $yuicompressor = realpath($tools . '/yuicompressor-2.4.8.jar');

        foreach (Yii::$app->params['assets']['css']['min'] as $min) {
            $cmd = sprintf('java -jar %s --preservehints --type css -o %s %s', $yuicompressor, $tmp, $path . '/' . $min);
            exec($cmd);

            $cssContent .= file_get_contents($tmp);
        }

        //-
        file_put_contents($path . '/css/allstyles.' . Yii::$app->version . '.min.css', $cssContent);
        unlink($tmp);

        $tmp = '/tmp/minscss.' . time() . '.js';
        $jsCompiler = realpath($tools . '/compiler.jar');
        foreach (Yii::$app->params['assets']['js']['min'] as $min) {
            $cmd = sprintf('java -jar %s --assume_function_wrapper --js %s --js_output_file %s', $jsCompiler, ($path . '/' . $min), $tmp);
            exec($cmd);

            $jsContent .= file_get_contents($tmp);
        }

        file_put_contents($path . '/js/allscripts.' . Yii::$app->version . '.min.js', $jsContent);
        return 0;
    }

    /**
     * @inheritdoc
     */
    public function getHelpSummary() {
        return '//TODO: ...';
    }

}
