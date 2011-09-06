<?php

/*
 * WidgetPlugin.php
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
 * A <em>WidgetPlugin</em> is a plugin that offers some widget to present in the
 * dashboad.
 * 
 * By implementing this interface, a plugin is being marked as one that wants 
 * to be shown in the dashboard.
 */
interface WidgetPlugin {

    /**
     * The ID used in HTML code to identify the widget. It's basically the name 
     * of the plugin class.
     * 
     * @return string The ID for the widget plugin.
     */
    public function getWidgetId();

    /**
     * Returns the title for this widget.
     * 
     * @return string The title to use in the dashboard.
     */
    public function getWidgetTitle(View $view);

    /**
     * Returns the widget content that will be placed in the dashboard.
     * 
     * return string The content to show.
     */
    public function getWidgetContent(View $view);
}
