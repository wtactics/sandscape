
<?php

/**
 * m160414_134008_schema_creation.php
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
use yii\db\Migration;

class m160414_134008_schema_creation extends Migration {

    /**
     * @inheritdoc
     */
    public function safeUp() {
        $this->createTable('User', [
            'id' => $this->primaryKey(),
            'email' => $this->string()->notNull()->unique(),
            'password' => 'CHAR(60) NOT NULL',
            'name' => $this->string(),
            'role' => 'ENUM(\'player\', \'administrator\', \'gamemaster\') NOT NULL DEFAULT \'player\'',
            'showChatTimes' => $this->boolean()->notNull()->defaultValue(1),
            'reverseCards' => $this->boolean()->notNull()->defaultValue(1),
            'onHoverDetails' => $this->boolean()->notNull()->defaultValue(1),
            'handCorner' => 'ENUM(\'left\', \'right\') NOT NULL DEFAULT \'left\'',
            'active' => $this->boolean()->notNull()->defaultValue(1)
                ], 'ENGINE = InnoDB CHARACTER SET utf8 COLLATE utf8_unicode_ci');

        $this->createTable('Card', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull(),
            'rules' => $this->text(),
            'face' => $this->string(),
            'back' => $this->string(),
            'backFrom' => 'ENUM(\'default\', \'own\', \'deck\') NOT NULL DEFAULT \'default\''
                ], 'ENGINE = InnoDB CHARACTER SET utf8 COLLATE utf8_unicode_ci');

        $this->createTable('Deck', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull(),
            'createdOn' => $this->dateTime()->notNull(),
            'back' => $this->string(),
            'ownerId' => $this->integer()
                ], 'ENGINE = InnoDB CHARACTER SET utf8 COLLATE utf8_unicode_ci');
        $this->addForeignKey('fkDeckUser', 'Deck', 'ownerId', 'User', 'id');

        $this->createTable('DeckCard', [
            'deckId' => $this->integer()->notNull(),
            'cardId' => $this->integer()->notNull(),
            'count' => $this->smallInteger()->unsigned()->defaultValue(1),
            'PRIMARY KEY(`deckId`, `cardId`)'
                ], 'ENGINE = InnoDB CHARACTER SET utf8 COLLATE utf8_unicode_ci');
        $this->addForeignKey('fkDCDeck', 'DeckCard', 'deckId', 'Deck', 'id');
        $this->addForeignKey('fkDCCard', 'DeckCard', 'cardId', 'Card', 'id');

        $this->createTable('Token', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull(),
            'image' => $this->string()->notNull(),
            'description' => $this->text()
                ], 'ENGINE = InnoDB CHARACTER SET utf8 COLLATE utf8_unicode_ci');

        $this->createTable('State', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull(),
            'image' => $this->string()->notNull(),
            'description' => $this->text()
                ], 'ENGINE = InnoDB CHARACTER SET utf8 COLLATE utf8_unicode_ci');

        $this->createTable('Dice', [
            'id' => $this->primaryKey(),
            'face' => $this->smallInteger()->unsigned()->defaultValue(6),
            'name' => $this->string()->notNull(),
            'description' => $this->text(),
            'enabled' => $this->boolean()->notNull()->defaultValue(1)
                ], 'ENGINE = InnoDB CHARACTER SET utf8 COLLATE utf8_unicode_ci');

        $this->createTable('Counter', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull(),
            'startValue' => $this->integer()->notNull(),
            'step' => $this->integer()->notNull()->defaultValue(1),
            'enabled' => $this->boolean()->notNull()->defaultValue(1),
            'description' => $this->text()
                ], 'ENGINE = InnoDB CHARACTER SET utf8 COLLATE utf8_unicode_ci');
    }

    /**
     * @inheritdoc
     */
    public function safeDown() {
        $this->dropTable('Counter');
        $this->dropTable('Dice');
        $this->dropTable('State');
        $this->dropTable('Token');
        $this->dropTable('DeckCard');
        $this->dropTable('Deck');
        $this->dropTable('Card');
        $this->dropTable('User');
    }

}
