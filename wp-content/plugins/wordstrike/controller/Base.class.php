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


}//end class

?>