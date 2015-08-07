<?php
define('theme_apps', TEMPLATEPATH.'/apps');

function IncludeAll($dir){
    $dir = realpath($dir);
    if ($dir) {
        $files = scandir($dir);
        sort($files);
        foreach ($files as $file) {
            if ($file == '.' || $file == '..') {
                continue;
            } elseif (preg_match('/.php$/i', $file)) {
                include_once $dir.'/'.$file;
            }
        }//end foreach
    }//end if
}

IncludeAll( theme_apps );