<?php

/*
 * TextEditor.php
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
 * WYSIWYG text editor component.
 * 
 * It uses elRTE JS editor to create a rich text editor.
 */
class TextEditor extends Component {

    private $id;
    private $value;
    private $extra;

    public function __construct($view, $model = null, $attribute = 'editor', $extra = array(), $properties = array(), $fmanager = array()) {
        parent::__construct($view);
        $lang = Config::getInstance()->get('system.locale.language');

        $view->registerStyle('css/elrte/elrte.min.css', 'ui');
        $view->registerStyle('css/elrte/elrte-inner.css', 'ui');
        $view->registerStyle('css/elfinder/elfinder.css', 'ui');

        $view->registerScript('js/elrte/elrte.min.js', 'ui');
        if (is_file(APPROOT . '/core/ui/js/elrte/i18n/elrte.' . $lang . '.js')) {
            $view->registerScript('js/elrte/i18n/elrte.' . $lang . '.js', 'ui');
            $properties['lang'] = "'{$lang}'";
        }

        $view->registerScript('js/elfinder/elfinder.min.js', 'ui');
        if (is_file(APPROOT . '/core/ui/js/elfinder/i18n/elfinder.' . $lang . '.js')) {
            $view->registerScript('js/elfinder/i18n/elfinder.' . $lang . '.js', 'ui');
            $fmanager['lang'] = "'{$lang}'";
        }

        $options = '';
        if (count($properties)) {

            foreach ($properties as $name => $value) {
                $options .= "{$name}: {$value},";
            }
        }

        if (count($fmanager)) {
            $options .= 'fmOpen : function(callback) {';
            $options .= "$('<div id=\"{$attribute}\" />').elfinder({";
            foreach ($fmanager as $name => $value) {
                $options .= "{$name}: {$value},";
            }
            $options .= 'editorCallback : callback';
            $options .= '})}';
        }

        $view->registerInitScript("$('#{$attribute}').elrte({ {$options} });");

        $this->id = $attribute;

        if ($model && is_object($model)) {
            $call = 'get' . $attribute;
            $this->value = $model->$call();
        }

        $this->extra = $extra;
    }

    public

    function __toString() {
        $extra = '';
        foreach ($this->extra as $attr => $value) {
            $extra .= $attr . '="' . $value . '"';
        }

        return (
                '<textarea id="' . $this->id . '" name="' . $this->id . '"' .
                $extra . '>' . $this->value . '</textarea>'
                );
    }

}