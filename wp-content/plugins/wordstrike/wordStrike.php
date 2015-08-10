<?php
/**
 * @package wordStrike
 */
/*
Plugin Name: wordStrike
Version: 1.0.0
Author: chenglinz
License: GPLv2 or later
Text Domain: wordsstrike
*/
define( 'WORDSTRIKE_DIR', plugin_dir_path( __FILE__ ) );

require_once( WORDSTRIKE_DIR . 'class.wordStrike.php' );

//Active
register_activation_hook(__FILE__, array('wordStrike' , 'init'));