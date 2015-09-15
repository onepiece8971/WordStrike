<?php
/**
 * WordStrike基础类
 *
 * PHP version 5.3
 *
 * @category  Base
 * @package   WordStrike
 * @author    chenglinz <onepiece8971@163.com>
 * @copyright 2015-2016 Squiz Pty Ltd (ABN 77 084 670 600)
 * @license   https://github.com/onepiece8971/WordStrike/licence.txt BSD Licence
 * @link      https://github.com/onepiece8971/WordStrike
 */

/**
 * Class Base
 *
 * @category Base
 * @package  WordStrike
 * @author   chenglinz <onepiece8971@163.com>
 * @license  https://github.com/onepiece8971/WordStrike/licence.txt BSD Licence
 * @link     https://github.com/onepiece8971/WordStrike
 */
class Base
{

    /**
     * 类集合
     *
     * @var array
     */
    protected static $instances = array();


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