<?php

/* resource-compress.php
 * 
 * This file is part of Sandscape, a virtual, browser based, table allowing 
 * people to play a customizable card games (CCG) online.
 *
 * Copyright (c) 2011 - 2013, the Sandscape team.
 * 
 * Sandscape uses several third party libraries and resources, a complete list 
 * can be found in the <README> file and in <_dev/thirdparty/about.html>.
 * 
 * Sandscape's team members are listed in the <CONTRIBUTORS> file.
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

$cssPath = realpath(dirname(__FILE__) . '/../www/_resources/css/sandscape');
$jsPath = realpath(dirname(__FILE__) . '/../www/_resources/js/sandscape');

echo "YUI Compressor execution starting..\n";
if (($dh = opendir($cssPath))) {
    echo "Working on CSS folder...\n";
    while ($css = readdir($dh)) {
        if ($css !== '.' && $css !== '..' && strpos($css, '.min.') === false
                && (strlen($css) - 4) === strpos($css, '.css')) {

            $name = explode('.css', $css);
            $name = $name[0];
            system("java -jar yuicompressor-2.4.6.jar -v {$cssPath}/{$name}.css -o {$cssPath}/{$name}.min.css --charset utf-8");
        }
    }
    closedir($dh);
    echo "Finished CSS folder...\n";
}

if (($dh = opendir($jsPath))) {
    echo "Working on JS folder...\n";
    while (($js = readdir($dh))) {
        if ($js !== '.' && $js !== '..' && strpos($js, '.min.') === false
                && (strlen($js) - 3) === strpos($js, '.js')) {

            $name = explode('.js', $js);
            $name = $name[0];

            system("java -jar yuicompressor-2.4.6.jar -v {$jsPath}/{$name}.js -o {$jsPath}/{$name}.min.js --charset utf-8");
        }
    }
    closedir($dh);
    echo "Finished JS folder...\n";
}
echo "YUI Compressor finished.\n";