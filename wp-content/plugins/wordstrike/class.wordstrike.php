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
        //单词表
        self::$sql_array['words'] = <<<def
            CREATE TABLE IF NOT EXISTS `{$table_prefix}words` (
    			id int NOT NULL PRIMARY KEY auto_increment,
    			word_name varchar(64) not null,
    			means varchar(256) not null,
    			part varchar(64) comment '词性',
    			phonetic varchar(64) comment '音标',
    			voice varchar(128) comment '音频地址',
    			act bit(1) not null default 1,
    			UNIQUE KEY word_name (word_name)
    			) DEFAULT CHARSET=utf8;
def;
        //单词本表
        self::$sql_array['words_books'] = <<<def
            CREATE TABLE IF NOT EXISTS `{$table_prefix}words_books` (
    			id int NOT NULL PRIMARY KEY auto_increment,
    			name varchar(128) not null,
    			content varchar(128),
    			img_url varchar(128),
    			create_time int(10) not null,
    			act bit(1) not null default 1
    			) DEFAULT CHARSET=utf8;
def;
        //单词本与单词关联表
        self::$sql_array['words_books_words'] = <<<def
            CREATE TABLE IF NOT EXISTS `{$table_prefix}words_books_words` (
    			books_id int NOT NULL,
    			words_id int NOT NULL,
    			KEY books_id (books_id),
    			KEY words_id (words_id)
    			) DEFAULT CHARSET=utf8;
def;
        //背词表
        self::$sql_array['recite'] = <<<def
            CREATE TABLE IF NOT EXISTS `{$table_prefix}recite` (
    			words_id int NOT NULL,
    			uid INT NOT NULL,
    			level int(2) not null default 1,
    			level_time int(9) not null default 300,
    			create_time int(10) not null,
    			update_time int(10) not null,
    			act bit(1) not null default 1,
    			KEY uid (uid),
    			KEY words_id (words_id),
    			KEY create_time (create_time),
    			KEY update_time (update_time)
    			) DEFAULT CHARSET=utf8;
def;
        //用户单词本表
        self::$sql_array['user_words_books'] = <<<def
            CREATE TABLE IF NOT EXISTS `{$table_prefix}user_words_books` (
    			books_id int NOT NULL,
    			uid int NOT NULL,
    			create_time int(10) not null,
    			act bit(1) not null default 1,
    			KEY books_id (books_id),
    			KEY uid (uid)
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

    /**
     * 多维数组关键字转一维数组
     *
     * @param $array
     * @param $key
     * @return array
     */
    public static function getArrayValues($array, $key)
    {
        $new_array = array();
        foreach ($array as $arr) {
            array_push($new_array, $arr[$key]);
        }
        return $new_array;
    }

    /**
     * 取得正则匹配的内容
     *
     * @param $str
     * @return mixed
     */
    public static function trim_word($str)
    {
        preg_match('/^[a-zA-Z.]*/', $str, $matches);
        return $matches[0];
    }
}