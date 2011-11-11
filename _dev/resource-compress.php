<?php

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

            system("java -jar yuicompressor-2.4.6.jar -v {$jsPath}/{$name}.js -o {$jsPath}{$name}.min.js --charset utf-8");
        }
    }
    closedir($dh);
    echo "Finished JS folder...\n";
}
echo "YUI Compressor finished.\n";