<?php
/**
 * Utility 公共方法
 *
 * PHP version 5.3
 *
 * @category  Utility
 * @package   WordStrike
 * @author    chenglinz <onepiece8971@163.com>
 * @copyright 2015-2016 Squiz Pty Ltd (ABN 77 084 670 600)
 * @license   https://github.com/onepiece8971/WordStrike/licence.txt BSD Licence
 * @link      https://github.com/onepiece8971/WordStrike
 */

/**
 * Class Utility
 *
 * @category Utility
 * @package  WordStrike
 * @author   chenglinz <onepiece8971@163.com>
 * @license  https://github.com/onepiece8971/WordStrike/licence.txt BSD Licence
 * @link     https://github.com/onepiece8971/WordStrike
 */
class Utility
{


    /**
     * 多维数组关键字转一维数组
     *
     * @param array  $array 多维数组
     * @param string $key   键
     *
     * @return array
     */
    public static function getArrayValues($array, $key)
    {
        $newArray = array();
        foreach ($array as $arr) {
            array_push($newArray, $arr[$key]);
        }

        return $newArray;

    }//end getArrayValues()


    /**
     * 取纯字母的字符串
     *
     * @param string $str 字符串
     *
     * @return mixed
     */
    public static function trimWord($str)
    {
        preg_match('/^[a-zA-Z.]*/', $str, $matches);
        return $matches[0];

    }//end trimWord()


}//end class

?>