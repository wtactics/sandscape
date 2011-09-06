<?php

/*
 * Resource.php
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
 * The <em>Resource</em> class is responsible for getting resource files and 
 * presenting them to the browser. It's used to get resources from their 
 * specific locations, such as the UI folder, the theme's folder or the plugin's 
 * folder.
 * 
 * It's also responsible for getting files out of the <em>data/uploads</em> folder.
 */
class Resource extends Controller {

    public function __construct() {
        parent::__construct();
    }

    public function start() {
        header('HTTP/1.0 403 Forbidden');
    }

    /**
     * Outputs the resource.
     * This method decides where to look for the file based on the URL for the 
     * resource and it's parameters. It will read the file's contents and send 
     * them to the browser or output a 404 header if the file is not found.
     * 
     * @param array $params Default URL parameters
     */
    public function get($params = array()) {
        $path = null;
        if (is_array($params) && isset($params[0])) {
            $path = array_shift($params);
            if ($path === 'ui') {
                $path = APPROOT . '/core/ui';
            } else if ($path === 'plugin') {
                $path = PLUGINROOT;
            } else {
                $path = APPROOT . '/themes/' . $path;
            }
            $path = $path . '/' . implode('/', $params);

            if (is_file($path)) {
                header('Content-Type: ' . $this->mimes[pathinfo($path, PATHINFO_EXTENSION)]);
                readfile($path);
            } else {
                header('HTTP/1.0 404 Not Found');
            }
        }
    }

    /**
     * Outputs a file from the <em>data/uploads</em> folder.
     * 
     * @param array $params Default URL parameters.
     */
    public function file($params = array()) {
        $path = null;
        if (is_array($params) && isset($params[0])) {
            $path = DATAROOT . '/uploads/' . implode('/', $params);

            if (is_file($path)) {
                header('Content-Type: ' . $this->mimes[pathinfo($path, PATHINFO_EXTENSION)]);
                readfile($path);
            }
        }
    }

    /**
     * Known mimetypes.
     * 
     * @var array Any file that needs to be output by the 
     * resource class requires a corresponding mimetype.
     */
    private $mimes = array(
        //applications
        'ai' => 'application/postscript',
        'eps' => 'application/postscript',
        'exe' => 'application/octet-stream',
        'doc' => 'application/vnd.ms-word',
        'xls' => 'application/vnd.ms-excel',
        'ppt' => 'application/vnd.ms-powerpoint',
        'pps' => 'application/vnd.ms-powerpoint',
        'pdf' => 'application/pdf',
        'xml' => 'application/xml',
        'odt' => 'application/vnd.oasis.opendocument.text',
        'swf' => 'application/x-shockwave-flash',
        // archives
        'gz' => 'application/x-gzip',
        'tgz' => 'application/x-gzip',
        'bz' => 'application/x-bzip2',
        'bz2' => 'application/x-bzip2',
        'tbz' => 'application/x-bzip2',
        'zip' => 'application/zip',
        'rar' => 'application/x-rar',
        'tar' => 'application/x-tar',
        '7z' => 'application/x-7z-compressed',
        // texts
        'txt' => 'text/plain',
        'php' => 'text/x-php',
        'html' => 'text/html',
        'htm' => 'text/html',
        'js' => 'text/javascript',
        'css' => 'text/css',
        'rtf' => 'text/rtf',
        'rtfd' => 'text/rtfd',
        'py' => 'text/x-python',
        'java' => 'text/x-java-source',
        'rb' => 'text/x-ruby',
        'sh' => 'text/x-shellscript',
        'pl' => 'text/x-perl',
        'sql' => 'text/x-sql',
        // images
        'bmp' => 'image/x-ms-bmp',
        'jpg' => 'image/jpeg',
        'jpeg' => 'image/jpeg',
        'gif' => 'image/gif',
        'png' => 'image/png',
        'tif' => 'image/tiff',
        'tiff' => 'image/tiff',
        'tga' => 'image/x-targa',
        'psd' => 'image/vnd.adobe.photoshop',
        'ico' => 'image/vnd.microsoft.icon',
        //audio
        'mp3' => 'audio/mpeg',
        'mid' => 'audio/midi',
        'ogg' => 'audio/ogg',
        'mp4a' => 'audio/mp4',
        'wav' => 'audio/wav',
        'wma' => 'audio/x-ms-wma',
        // video
        'avi' => 'video/x-msvideo',
        'dv' => 'video/x-dv',
        'mp4' => 'video/mp4',
        'mpeg' => 'video/mpeg',
        'mpg' => 'video/mpeg',
        'mov' => 'video/quicktime',
        'wm' => 'video/x-ms-wmv',
        'flv' => 'video/x-flv',
        'mkv' => 'video/x-matroska'
    );

}

