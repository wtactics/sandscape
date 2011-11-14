<?php

/* DeckTemplateCard.php
 * 
 * This file is part of Sandscape.
 *
 * Sandscape is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 * 
 * Sandscape is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 * 
 * You should have received a copy of the GNU General Public License
 * along with Sandscape.  If not, see <http://www.gnu.org/licenses/>.
 * 
 * Copyright (c) 2011, the Sandscape team and WTactics project.
 * http://wtactics.org
 */

/**
 * @property int $dtcId
 * @property int $cardId
 * @property int $deckTemplateId
 * 
 * Relations:
 * @property DeckTemplate $template
 * @property Card $card
 * 
 * @since 1.1, Green Shield
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