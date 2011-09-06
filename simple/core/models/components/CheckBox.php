<?php

/*
 * CheckBox.php
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
 * A checkbox type input.
 */
class CheckBox extends HTMLElement {

    private $value;
    private $checked;

    public function __construct($model, $attribute, $extra = array()) {
        parent::__construct($attribute, $attribute, $extra);

        $this->value = 1;
        if ($model) {
            $call = 'get' . $attribute;
            $this->checked = $model->$call() ? true : false;
        }
    }

    public function __toString() {
        return '<input type="checkbox" ' . parent::__toString() .
                ($this->checked ? ' checked="checked"' : '') .
                ($this->value ? 'value="' . $this->value . '"' : '') . ' />';
    }

}