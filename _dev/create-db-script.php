<?php

$stop = 'last';
$output = 'sandscape.db.sql';
$databaseFolder = __DIR__ . '/database';

if (($fh = fopen($output, 'w'))) {
    if (($dh = opendir($databaseFolder))) {

        while (($entry = readdir($dh))) {
            if ($entry != '.' && $entry != '..' && is_dir($databaseFolder . '/' . $entry)) {

                if (($dh2 = opendir($databaseFolder . '/' . $entry))) {

                    while (($file = readdir($dh2))) {
                        if (is_file($databaseFolder . '/' . $entry . '/' . $file)) {
                            fwrite($fh, file_get_contents());
                        }
                    }
                    closedir($dh2);
                    fflush($fh);
                }

                if ($entry === $stop) {
                    break;
                }
            }
        }
        closedir($dh);
    }

    fclose($fh);
}