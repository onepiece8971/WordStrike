<?php
/**
 * WordStrike插件.
 *
 * @package WordStrike
 */

/*
Plugin Name: wordStrike
Version: 1.0.0
Author: chenglinz
License: GPLv2 or later
Text Domain: WordStrike
*/


define( 'WORDSTRIKE_DIR', plugin_dir_path( __FILE__ ) );

// WordStrike前缀
$GLOBALS['wordStrikePrefix'] = isset($wordStrikePrefix) ? $wordStrikePrefix : 'ws_';

// Active.
register_activation_hook( __FILE__, array('WordStrike', 'init') );

//添加自定义菜单
function add_menu_function(){
    add_menu_page( 'wordstrike', 'wordstrike', 'administrator', 'wordstrike', 'display_function');
}
function display_function(){
    include( WORDSTRIKE_DIR.'template/wordstrike.tpl.php' );
}
add_action('admin_menu', 'add_menu_function');

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

IncludeApps( WORDSTRIKE_DIR.'api' );
IncludeApps( WORDSTRIKE_DIR.'apps' );
IncludeApps( WORDSTRIKE_DIR.'controller' );
IncludeApps( WORDSTRIKE_DIR.'model' );