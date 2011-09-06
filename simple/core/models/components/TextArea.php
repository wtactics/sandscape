<?php

/*
 * TextArea.php
 *
 * (C) 2011, StaySimple team.
 *
 * This file is part of StaySimple.
 * http://code.google.com/p/stay-simple-cms/
 *
 * StaySimple is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * StaySimple is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with StaySimple.  If not, see <http://www.gnu.org/licenses/>.
 */

/**
 * Generic text area.
 */
class TextArea extends HTMLElement {

    private $value;
    private $rows;
    private $cols;

    public function __construct($model, $attribute, $rows = 3, $cols = 50, $extra = array()) {
        parent::__construct($attribute, $attribute, $extra);

        $value = null;
        if (array_key_exists('value', $extra)) {
            $value = $extra['value'];
            unset($extra['value']);
        }
        $this->setExtra($extra);

        if ($model) {
            $call = 'get' . $attribute;
            $this->value = $model->$call();
        } else {
            $this->value = $value;
        }

        $this->rows = $rows;
        $this->cols = $cols;
    }

    public function __toString() {
        return (
                '<textarea ' . parent::__toString() . 'rows="' . $this->rows .
                '" cols="' . $this->cols . '">' . ($this->value ? $this->value : '') .
                '</textarea>'
                );
    }

}
