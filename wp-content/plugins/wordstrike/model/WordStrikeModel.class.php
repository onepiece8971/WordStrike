<?php
/**
 * WordStrike初始Model
 *
 * PHP version 5.3
 *
 * @category  WordStrikeModel
 * @package   WordStrike
 * @author    chenglinz <onepiece8971@163.com>
 * @copyright 2015-2016 Squiz Pty Ltd (ABN 77 084 670 600)
 * @license   https://github.com/onepiece8971/WordStrike/licence.txt BSD Licence
 * @link      https://github.com/onepiece8971/WordStrike
 */

/**
 * Class WordStrikeModel
 *
 * @category WordStrikeModel
 * @package  WordStrike
 * @author   chenglinz <onepiece8971@163.com>
 * @license  https://github.com/onepiece8971/WordStrike/licence.txt BSD Licence
 * @link     https://github.com/onepiece8971/WordStrike
 */
class WordStrikeModel extends BaseModel
{

    /**
     * 数据库表前缀.
     *
     * @var string
     */
    private static $_tablePrefix;

    /**
     * sql集合.
     *
     * @var array
     */
    public static $sqlArray = array();


    /**
     * 初始化方法
     *
     * @return mixed
     */
    public static function init()
    {
        if (empty(self::$sqlArray) === true) {
            self::_createSql();
        }

    }//end init()


    /**
     * 获取数据库表前缀
     *
     * @return string
     */
    public static function getTablePrefix()
    {
        if (empty(self::$_tablePrefix) === true) {
            self::$_tablePrefix = $GLOBALS['wordStrikePrefix'];
        }

        return self::$_tablePrefix;

    }//end getTablePrefix()


    /**
     * 新建$sqlArray
     *
     * @return void
     */
    private static function _createSql()
    {
        $tablePrefix = self::getTablePrefix();
        // 单词表.
        self::$sqlArray['words'] = "CREATE TABLE IF NOT EXISTS `{$tablePrefix}words` (
    			id int NOT NULL PRIMARY KEY auto_increment,
    			word_name varchar(64) not null,
    			means varchar(256) not null,
    			part varchar(64) comment '词性',
    			phonetic varchar(64) comment '音标',
    			voice varchar(128) comment '音频地址',
    			act bit(1) not null default 1,
    			UNIQUE KEY word_name (word_name)
    			) DEFAULT CHARSET=utf8";
        // 单词本表.
        self::$sqlArray['words_books'] = "CREATE TABLE IF NOT EXISTS `{$tablePrefix}words_books` (
    			id int NOT NULL PRIMARY KEY auto_increment,
    			name varchar(128) not null,
    			content varchar(128),
    			img_url varchar(128),
    			create_time int(10) not null,
    			act bit(1) not null default 1
    			) DEFAULT CHARSET=utf8";
        // 单词本与单词关联表.
        self::$sqlArray['words_books_words'] = "CREATE TABLE IF NOT EXISTS `{$tablePrefix}words_books_words` (
    			books_id int NOT NULL,
    			words_id int NOT NULL,
    			KEY books_id (books_id),
    			KEY words_id (words_id)
    			) DEFAULT CHARSET=utf8";
        // 背词表.
        self::$sqlArray['recite'] = "CREATE TABLE IF NOT EXISTS `{$tablePrefix}recite` (
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
    			) DEFAULT CHARSET=utf8";
        // 用户单词本表.
        self::$sqlArray['user_words_books'] = "CREATE TABLE IF NOT EXISTS `{$tablePrefix}user_words_books` (
    			books_id int NOT NULL,
    			uid int NOT NULL,
    			create_time int(10) not null,
    			act bit(1) not null default 1,
    			KEY books_id (books_id),
    			KEY uid (uid)
    			) DEFAULT CHARSET=utf8";

    }//end _createSql()


}//end class

?>