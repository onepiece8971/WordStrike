<?php
/**
 * BaseModel
 *
 * PHP version 5.3
 *
 * @category  BaseModel
 * @package   WordStrike
 * @author    chenglinz <onepiece8971@163.com>
 * @copyright 2015-2016 Squiz Pty Ltd (ABN 77 084 670 600)
 * @license   https://github.com/onepiece8971/WordStrike/licence.txt BSD Licence
 * @link      https://github.com/onepiece8971/WordStrike
 */

/**
 * Class BaseModel
 *
 * @category BaseModel
 * @package  WordStrike
 * @author   chenglinz <onepiece8971@163.com>
 * @license  https://github.com/onepiece8971/WordStrike/licence.txt BSD Licence
 * @link     https://github.com/onepiece8971/WordStrike
 */
class BaseModel
{

    /**
     * 类集合
     *
     * @var array
     */
    protected static $instances = array();

    /**
     * wordStrike表前缀
     *
     * @var
     */
    protected static $tablePrefix;

    /**
     * 用户id
     *
     * @var int
     */
    protected static $uid;

    /**
     * wordpress db class
     *
     * @var
     */
    protected static $wpDb;


    /**
     * 构造函数
     */
    public function __construct()
    {
        // 获取当前用户id.
        if (empty(self::$uid) === true) {
            $currentUser = wp_get_current_user();
            self::$uid   = $currentUser->ID;
        }

        // 获取表前缀.
        if (empty(self::$tablePrefix) === true) {
            self::$tablePrefix = $GLOBALS['wordStrikePrefix'];
        }

        // 获取wordpress db class.
        if (empty(self::$wpDb) === true) {
            self::$wpDb = $GLOBALS['wpdb'];
        }

    }//end __construct()


    /**
     * 工厂方法
     *
     * @return mixed
     */
    public static function init()
    {
        $className = get_called_class();
        if (isset(self::$instances[$className]) === false) {
            self::$instances[$className] = new $className();
        }

        return self::$instances[$className];

    }//end init()


    /**
     * 判断数据是否存在
     *
     * @param string $query SQL语句
     *
     * @return bool
     */
    public function exists($query)
    {
        $result = self::$wpDb->get_row($query);
        return empty($result);

    }//end exists()


}//end class

?>