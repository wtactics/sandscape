<?php

/*
 * IPluginConfigurable.php
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
 * Specifies a plugin with configuration controller.
 * 
 * The controller will be responsible for all the actions and views that are 
 * needed to configure this plugin. It should, also, be a subclass of 
 * <em>Administration</em> to be able to verify the user's credential.
 */
interface IPluginConfigurable {

    /**
     * Return the controller that configures this plugin. If the plugin 
     * implements <em>IPluginConfigurable</em> then it must provide a controller
     * with the necessary methods and views.
     * 
     * @return string The name of the controller class that offers configuration 
     * options.
     */
    public function configController();
}

?>