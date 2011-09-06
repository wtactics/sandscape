<?php

/*
 * Dashboard.php
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
 * The <em>Dashboard</em> controller shows general statistcs and information 
 * to the user.
 */
class Dashboard extends Administration {

    public function __construct() {
        parent::__construct();
        $this->validateUser();
    }

    public function start() {
        $widgets = Plugin::getPlugins('widget');
        $column1 = array();
        $column2 = array();

        if (($max = count($widgets)) > 0) {

            $xml = DATAROOT . '/settings/dashboard.xml';
            if (is_file($xml)) {
                $existing = 0;
                $xml = new XMLFile($xml);
                foreach ($xml->widget as $widget) {
                    $column = intval($widget->attributes()->column);
                    $id = strval($widget->attributes()->id);
                    if ($column == 1) {
                        $column1[intval($widget->attributes()->order)] = $id;
                    } else {
                        $column2[intval($widget->attributes()->order)] = $id;
                    }
                    unset($widgets[$id]);
                }

                if (!empty($widgets)) {
                    foreach ($widgets as $plugin) {
                        $column1[] = $plugin->instance->getWidgetId();
                    }
                    $this->saveWidgetCache($column1, $column2);
                }
            } else {
                $half = ceil($max / 2);

                $i = 0;
                foreach ($widgets as $key => $plugin) {
                    $column1[$i] = $plugin->instance->getWidgetId();
                    unset($widgets[$key]);

                    if ($i == $half - 1) {
                        break;
                    }
                }

                $i = $half;
                foreach ($widgets as $plugin) {
                    $column2[$i] = $plugin->instance->getWidgetId();
                }
                $this->saveWidgetCache($column1, $column2);
            }
        }
        //getting the plugins again
        $widgets = Plugin::getPlugins('widget');

        $this->render('dashboard', array('column1' => $column1, 'column2' => $column2, 'widgets' => $widgets));
    }

    public function updateWidget($params = array()) {
        if (isset($_POST['column1']) && isset($_POST['column2'])) {
            $this->saveWidgetCache($_POST['column1'], $_POST['column2']);
        }
    }

    /**
     * Saves the current widgets' order.
     * 
     * @param array $column1 The first column's configuration.
     * @param array $column2 The second column's configuration.
     * @return boolean True if the cache was saved, false otherwise.
     */
    private function saveWidgetCache($column1, $column2) {
        $xml = new XMLFile('<dashboard version="' . SSVERSION . '"></dashboard>');

        if (!empty($column1) && is_string($column1)) {
            $column1 = explode(',', $column1);
        }

        foreach ($column1 as $order => $widget) {
            $child = $xml->addChild('widget');
            $child->addAttribute('id', $widget);
            $child->addAttribute('column', 1);
            $child->addAttribute('order', $order + 1);
        }

        if (!empty($column2) && is_string($column2)) {
            $column2 = explode(',', $column2);
        }

        foreach ($column2 as $order => $widget) {
            $child = $xml->addChild('widget');
            $child->addAttribute('id', $widget);
            $child->addAttribute('column', 2);
            $child->addAttribute('order', $order + 1);
        }

        return $xml->asXML(DATAROOT . '/settings/dashboard.xml');
    }

}
