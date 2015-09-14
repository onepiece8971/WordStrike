<?php
/**
 * WordStrike初始文件
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

require_once ABSPATH.'wp-admin/upgrade-functions.php';

/**
 * Class WordStrike
 *
 * @category WordStrike
 * @package  WordStrike
 * @author   chenglinz <onepiece8971@163.com>
 * @license  https://github.com/onepiece8971/WordStrike/licence.txt BSD Licence
 * @link     https://github.com/onepiece8971/WordStrike
 */
class WordStrike
{


    /**
     * 插件初始化
     *
     * @return void
     */
    public static function init()
    {
        if (empty(WordStrikeModel::$sqlArray) === true) {
            WordStrikeModel::init();
        }

        foreach (WordStrikeModel::$sqlArray as $tableName => $sql) {
            self::_createTable($tableName, $sql);
        }

    }//end init()


    /**
     * 新建表
     *
     * @param string $tableName 表名
     * @param string $sql       sql语句
     *
     * @return void
     */
    private function _createTable($tableName, $sql)
    {
        $wpdb = $GLOBALS['wpdb'];
        if ($wpdb->get_var("show tables like '$tableName'") !== $tableName) {
            dbDelta($sql);
        }

    }//end _createTable()


}//end class

?>