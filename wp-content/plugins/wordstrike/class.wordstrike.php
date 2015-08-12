<?php

require_once(ABSPATH . 'wp-admin/upgrade-functions.php');

class wordStrike {

    public static $table_prefix = 'ws_';

    private static $sql_array = array();

    public static function init()
    {
        if (empty(self::$sql_array)) {
            self::createSql();
        }
        foreach (self::$sql_array as $key => $sql) {
            self::createTable($key, $sql);
        }
    }

    private function createSql()
    {
        $table_prefix = self::$table_prefix;
        self::$sql_array['words'] = <<<def
            CREATE TABLE IF NOT EXISTS `{$table_prefix}words` (
    			id int NOT NULL PRIMARY KEY auto_increment,
    			word_name varchar(64) not null,
    			means varchar(256) not null,
    			part varchar(64),
    			phonetic varchar(64),
    			create_time timestamp not null default current_timestamp,
    			activation bit(1) not null default 1,
    			UNIQUE KEY word_name (word_name)
    			) DEFAULT CHARSET=utf8;
def;
        self::$sql_array['words_books'] = <<<def
            CREATE TABLE IF NOT EXISTS `{$table_prefix}words_books` (
    			id int NOT NULL PRIMARY KEY auto_increment,
    			uid int NOT NULL,
    			name varchar(128) not null,
    			create_time timestamp not null default current_timestamp,
    			activation bit(1) not null default 1,
    			UNIQUE KEY word_name (word_name),
    			key uid (uid)
    			) DEFAULT CHARSET=utf8;
def;
        self::$sql_array['words_books_words'] = <<<def
            CREATE TABLE IF NOT EXISTS `{$table_prefix}words_books_words` (
    			books_id int NOT NULL,
    			words_id int NOT NULL,
    			level int not null,
    			create_time timestamp not null default current_timestamp,
    			activation bit(1) not null default 1,
    			key books_id (books_id)
    			key words_id (words_id)
    			) DEFAULT CHARSET=utf8;
def;

    }

    public function createTable($table_name, $sql)
    {
        global $wpdb;
        if($wpdb->get_var("show tables like '$table_name'") != $table_name){
            dbDelta($sql);
        }
    }
}