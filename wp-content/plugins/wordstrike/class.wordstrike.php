<?php

require_once(ABSPATH . 'wp-admin/upgrade-functions.php');

/**
 * Wordstrike插件主类.
 */
class Wordstrike
{
    /**
     * 数据库表前缀.
     *
     * @var string
     */
    public static $table_prefix = 'ws_';

    /**
     * ql集合.
     *
     * @var array
     */
    private static $sql_array = array();

    /**
     * 插件初始化
     */
    public static function init()
    {
        if (empty(self::$sql_array)) {
            self::createSql();
        }
        foreach (self::$sql_array as $key => $sql) {
            self::createTable($key, $sql);
        }
    }

    /**
     * 新建sql
     */
    private function createSql()
    {
        $table_prefix = self::$table_prefix;
        self::$sql_array['words'] = <<<def
            CREATE TABLE IF NOT EXISTS `{$table_prefix}words` (
    			id int NOT NULL PRIMARY KEY auto_increment,
    			word_name varchar(64) not null,
    			means varchar(256) not null,
    			part varchar(64) comment '词性',
    			phonetic varchar(64) comment '音标',
    			voice varchar(128),
    			act bit(1) not null default 1,
    			UNIQUE KEY word_name (word_name)
    			) DEFAULT CHARSET=utf8;
def;
        self::$sql_array['words_books'] = <<<def
            CREATE TABLE IF NOT EXISTS `{$table_prefix}words_books` (
    			id int NOT NULL PRIMARY KEY auto_increment,
    			uid int NOT NULL,
    			name varchar(128) not null,
    			create_time timestamp not null default current_timestamp,
    			act bit(1) not null default 1,
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
    			act bit(1) not null default 1,
    			KEY books_id (books_id)
    			KEY words_id (words_id)
    			) DEFAULT CHARSET=utf8;
def;

    }

    /**
     * 新建表
     *
     * @param $table_name
     * @param $sql
     */
    public function createTable($table_name, $sql)
    {
        global $wpdb;
        if($wpdb->get_var("show tables like '$table_name'") != $table_name){
            dbDelta($sql);
        }
    }
}