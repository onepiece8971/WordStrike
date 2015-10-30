<?php
define('THEME_APPS', TEMPLATEPATH.'/apps');

//自动加载
function IncludeApps($dir)
{
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

IncludeAll( THEME_APPS );

/**
 * WordPress 后台禁用Google Open Sans字体，加速网站
 * http://www.wpdaxue.com/disable-google-fonts.html
 */
add_filter( 'gettext_with_context', 'wpdx_disable_open_sans', 888, 4 );
function wpdx_disable_open_sans( $translations, $text, $context ) {
    if ( 'Open Sans font: on or off' == $context && 'on' == $text ) {
        $translations = 'off';
    }
    return $translations;
}