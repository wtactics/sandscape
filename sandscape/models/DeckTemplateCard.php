<?php

/* DeckTemplateCard.php
 * 
 * This file is part of Sandscape, a virtual, browser based, table allowing 
 * people to play a customizable card games (CCG) online.
 *
 * Copyright (c) 2011 - 2013, the Sandscape team.
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
 * @property int $dtcId
 * @property int $cardId
 * @property int $deckTemplateId
 * 
 * Relations:
 * @property DeckTemplate $template
 * @property Card $card
 */
class DeckTemplateCard extends CActiveRecord {

    /**
     * @return DeckTemplateCard
     */
    public static function model($className=__CLASS__) {
        return parent::model($className);
    }

    public function tableName() {
        return 'DeckTemplateCard';
    }

    public function relations() {
        return array(
            'template' => array(self::BELONGS_TO, 'DeckTemplate', 'deckTemplateId'),
            'card' => array(self::BELONGS_TO, 'Card', 'cardId'),
        );
    }

    public function attributeLabels() {
        return array(
            'cardId' => 'Card ID',
            'deckId' => 'Template ID',
        );
    }

}