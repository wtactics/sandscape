<?php

/*
 * Aditamentos.php
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

namespace app\models\filters;

use yii\data\ActiveDataProvider;
//-
use common\models\User;

/**
 * //TODO: documentation
 * 
 * @author Sérgio Lopes <knitter.is@gmail.com>
 * @copyright (c) 2016, WTactics Project
 */
final class Users extends \yii\base\Model {

    /** @var string */
    public $name;

    /** @var string */
    public $email;

    /** @var string */
    public $role;

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['name', 'email'], 'string', 'max' => 255],
            //TODO: use in array instead
            [['role'], 'safe']
        ];
    }

    /**
     * @param array $params
     * @param integer $pageSize
     * 
     * @return \yii\data\ActiveDataProvider
     */
    public function search($params, $pageSize = 50) {
        $query = User::find()->orderBy('name');
        $provider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => ['pageSize' => $pageSize],
            'sort' => false
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $provider;
        }

        //TODO: search filter
        $query->andFilterWhere(['like', 'name', $this->name])
                ->andFilterWhere(['like', 'email', $this->email])
                ->andFilterWhere(['role' => $this->role]);


        return $provider;
    }

}
