<?php

/*
 * autoload.php
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

function __autoload($name) {

    $class = APPROOT . '/core/base/' . $name . '.php';
    if (is_file($class)) {
        require $class;
        return;
    }

    $class = APPROOT . '/core/controllers/' . $name . '.php';
    if (is_file($class)) {
        require $class;
        return;
    }

    $class = APPROOT . '/core/controllers/admin/' . $name . '.php';
    if (is_file($class)) {
        require $class;
        return;
    }

    $class = APPROOT . '/core/managers/' . $name . '.php';
    if (is_file($class)) {
        require $class;
        return;
    }

    $class = APPROOT . '/core/models/' . $name . '.php';
    if (is_file($class)) {
        require $class;
        return;
    }

    $class = APPROOT . '/core/models/components/' . $name . '.php';
    if (is_file($class)) {
        require $class;
        return;
    }

    // Plugins ----
    // Other plugins class files can be added manually next to the plugin class 
    // declaration, no automatic discovery of new plugin class files is made!
    $class = PLUGINROOT . '/' . $name . '/' . $name . '.php';
    if (is_file($class)) {
        require $class;
        return;
    }
}