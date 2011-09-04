<?php

/*
 * models/ChatMessage.php
 * http://sandscape.sourceforge.net/
 * 
 * This file is part of SandScape.
 * 
 * SandScape is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 * 
 * SandScape is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 * 
 * You should have received a copy of the GNU General Public License
 * along with SandScape.  If not, see <http://www.gnu.org/licenses/>.
 * 
 * Copyright (c) 2011, the SandScape team and WTactics project.
 */

class ChatMessage extends CActiveRecord {

    public static function model($className=__CLASS__) {
        return parent::model($className);
    }

    public function relations() {
        return array(
            'chat' => array(self::BELONGS_TO, 'Chat', 'chatId'),
            'user' => array(self::BELONGS_TO, 'User', 'userId'),
        );
    }

}