<?php

/*
 * BackupManager.php
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

abstract class BackupManager extends Manager {

    public static function generateFull() {
        $tmp = tempnam('/tmp', 'sbk');

        $zip = new ZipArchive();
        if ($zip->open($tmp, ZipArchive::CREATE) !== true) {
            return false;
        }
        $data = DATAROOT . '/';

        $stack = array($data);
        $cutFrom = strrpos(substr($data, 0, -1), '/') + 1;

        while (!empty($stack)) {
            $currentDir = array_pop($stack);
            $filesToAdd = array();

            $dir = dir($currentDir);
            while (false !== ($node = $dir->read())) {
                if (($node == '..') || ($node == '.')) {
                    continue;
                }
                if (is_dir($currentDir . $node)) {
                    array_push($stack, $currentDir . $node . '/');
                }
                if (is_file($currentDir . $node)) {
                    $filesToAdd[] = $node;
                }
            }

            $localDir = substr($currentDir, $cutFrom);
            $zip->addEmptyDir($localDir);

            foreach ($filesToAdd as $file) {
                $zip->addFile($currentDir . $file, $localDir . $file);
            }
        }
        if (!$zip->close()) {
            return false;
        }

        return $tmp;
    }

    public static function deleteOld() {
        $deletable = array();

        if (($dh = opendir(DATAROOT . '/backups'))) {
            while (($page = readdir($dh)) !== false) {
                if (is_dir(DATAROOT . '/backups/' . $filename) && $filename != '.' && $filename != '..') {
                    if (($dh2 = opendir(DATAROOT . '/backups/' . $filename)) !== false) {
                        while (($backup = readdir($dh2)) !== false) {
                            if ($backup != '.' && $backup != '..') {
                                $deletable[$filename][] = DATAROOT . '/backups/' . $filename . '/' . $backup;
                            }
                        }
                        closedir($dh2);
                    }
                }
            }
            closedir($dh);
        }

        foreach ($deletable as $delete) {
            array_pop($delete);
            foreach ($delete as $file) {
                unlink($file);
            }
        }
    }

    /**
     *
     * @param string $name The name of the page to backup.
     * 
     * @return bool True on success or false if it wasn't possible to create the 
     * page backup.
     */
    public static function backupPage($name) {
        $base = DATAROOT . '/backups/' . $name;
        if (!is_dir($base)) {
            if (!mkdir($base)) {
                return false;
            }
        }

        $origin = DATAROOT . '/pages/' . $name . '.xml';
        $destination = $base . '/' . time();

        if (is_file($origin)) {
            return copy($origin, $destination);
        }

        return false;
    }

    public static function revertPageBackup($page, $date) {
        $origin = DATAROOT . '/backups/' . $page . '/' . $date;
        if (is_file($origin)) {
            $destination = DATAROOT . '/pages/' . $page . '.xml';
            return copy($origin, $destination);
        }
        return false;
    }

    public static function getBackups($name, $reverse = false) {
        $found = array();

        $dir = DATAROOT . '/backups/' . $name;
        if (is_dir($dir)) {
            if (($dh = opendir(DATAROOT . '/backups/' . $name))) {
                while (($filename = readdir($dh)) !== false) {
                    if ($filename != '.' && $filename != '..') {
                        $found[] = $filename;
                    }
                }
                closedir($dh);
            }
        }

        if ($reverse) {
            rsort($found);
        }

        return $found;
    }

}
