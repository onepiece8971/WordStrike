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