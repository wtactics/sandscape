<?php

/*
 * ComboBox.php
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
 * A select element.
 */
class ComboBox extends HTMLElement {

    private $values;
    private $selected;

    public function __construct($model, $attribute, $values = array(), $default = null, $extra = array()) {
        parent::__construct($attribute, $attribute, $extra);


        if ($model) {
            $call = 'get' . $attribute;
            $current = $model->$call();

            if (!is_array($values)) {
                $this->values = array($attribute => $current);
            } else {
                $this->values = $values;
            }

            $found = false;
            if ($current) {
                foreach ($this->values as $elem) {
                    if ($elem[0] == $current) {
                        $this->selected = $current;
                        $found = true;
                        break;
                    }
                }
            }

            if (!$current || !$found) {
                $this->selected = $default;
            }
        } else {
            $this->values = $values;
            $this->selected = $default;
        }
    }

    public function __toString() {
        $options = '';
        foreach ($this->values as $elem) {
            $options .= '<option value="' . $elem[0] . '"' . ($this->selected == $elem[0] ? ' selected="selected"' : '') . '>' . $elem[1] . '</option>';
        }

        return '<select ' . parent::__toString() . '>' . $options . '</select>';
    }

}