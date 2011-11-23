<?php

/* DeckTemplate.php
 * 
 * This file is part of Sandscape, a virtual, browser based, table allowing 
 * people to play a customizable card games (CCG) online.
 *
 * Copyright (c) 2011, the Sandscape team.
 * 
 * Sandscape uses several third party libraries and resources, a complete list 
 * can be found in the <README> file and in <_dev/thirdparty/about.html>.
 * 
 * Sandscape's team members are listed in the <CONTRIBUTORS> file.
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

/**
 *
 * @property int $deckTemplateId
 * @property string $name
 * @property string $created
 * @property int $active
 * 
 * Relations:
 * @property DeckTemplateCard[] $templatesCard
 * 
 * @since 1.1, Green Shield
 */
class DeckTemplate extends CActiveRecord {

    /**
     * @return DeckTemplate
     */
    public static function model($className=__CLASS__) {
        return parent::model($className);
    }

    public function tableName() {
        return 'DeckTemplate';
    }

    public function rules() {
        return array(
            array('name', 'required'),
            array('name', 'length', 'max' => 100),
            //search
            array('name', 'safe', 'on' => 'search'),
        );
    }

    public function relations() {
        return array(
            'templatesCard' => array(self::HAS_MANY, 'DeckTemplateCard', 'deckTemplateId'),
            'deck' => array(self::BELONGS_TO, 'Deck', 'deckId')
        );
    }

    public function attributeLabels() {
        return array(
            'deckTemplateId' => 'ID',
            'name' => 'Name',
            'created' => 'Created',
        );
    }

    public function search() {
        $criteria = new CDbCriteria();

        $criteria->compare('name', $this->name, true);
        $criteria->compare('active', 1);

        return new CActiveDataProvider('DeckTemplate', array('criteria' => $criteria));
    }

}