<?php
/**
 * Wordstrike插件.
 *
 * @package Wordstrike
 */

/*
Plugin Name: wordStrike
Version: 1.0.0
Author: chenglinz
License: GPLv2 or later
Text Domain: wordsstrike
*/
define( 'WORDSTRIKE_DIR', plugin_dir_path( __FILE__ ) );

require_once( WORDSTRIKE_DIR . 'class.wordstrike.php' );
require_once( WORDSTRIKE_DIR . 'class.study.php' );
require_once( WORDSTRIKE_DIR . 'class.words.php' );
require_once( WORDSTRIKE_DIR . 'class.wordsBooks.php' );
require_once( WORDSTRIKE_DIR . 'class.myWordsBook.php' );

// Active.
register_activation_hook( __FILE__, array('wordStrike', 'init') );

//添加自定义菜单
function add_menu_function(){
    add_menu_page( 'wordstrike', 'wordstrike', 'administrator', 'wordstrike', 'display_function');
}
function display_function(){
    include( WORDSTRIKE_DIR.'template/wordstrike.tpl.php' );
}
add_action('admin_menu', 'add_menu_function');

//自动加载
function IncludeApps($dir){
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
IncludeApps( WORDSTRIKE_DIR.'apps' );
IncludeApps( WORDSTRIKE_DIR.'controller' );
IncludeApps( WORDSTRIKE_DIR.'model' );