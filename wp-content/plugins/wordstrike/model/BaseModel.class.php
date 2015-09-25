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
            $this->uid   = $currentUser->ID;
        }

        // 获取表前缀.
        if (empty(self::$tablePrefix) === true) {
            $this->tablePrefix = $GLOBALS['wordStrikePrefix'];
        }

        // 获取wordpress db class.
        if (empty(self::$wpDb) === true) {
            $this->$wpDb = $GLOBALS['wpdb'];
        }

    }//end __construct()


    /**
     * 初始化方法
     *
     * @return mixed
     */
    public static function init()
    {
        return self::instance(__CLASS__);

    }//end init()


    /**
     * 工厂方法
     *
     * @param string $className 类名
     *
     * @return mixed
     */
    static protected function instance($className)
    {
        if (isset(self::$instances[$className]) === false) {
            self::$instances[$className] = new $className();
        }

        return self::$instances[$className];

    }//end instance()


}//end class

?>