<?php
/**
 * 复习表
 *
 * PHP version 5.3
 *
 * @category  ReciteModel
 * @package   WordStrike
 * @author    chenglinz <onepiece8971@163.com>
 * @copyright 2015-2016 Squiz Pty Ltd (ABN 77 084 670 600)
 * @license   https://github.com/onepiece8971/WordStrike/licence.txt BSD Licence
 * @link      https://github.com/onepiece8971/WordStrike
 */

/**
 * Class ReciteModel
 *
 * @category ReciteModel
 * @package  WordStrike
 * @author   chenglinz <onepiece8971@163.com>
 * @license  https://github.com/onepiece8971/WordStrike/licence.txt BSD Licence
 * @link     https://github.com/onepiece8971/WordStrike
 */
class ReciteModel extends BaseModel
{

    /**
     * 单词等级
     *
     * @var array
     */
    public static $level = array(
                            -1 => 30,
                            0  => 60,
                            1  => 300,
                            2  => 1800,
                            3  => 43200,
                            4  => 86400,
                            5  => 172800,
                            6  => 345600,
                            7  => 604800,
                            8  => 1296000,
                            9  => 2592000,
                           );


    /**
     * 实例化类
     *
     * @return object
     */
    public static function init()
    {
        return parent::instance(__CLASS__);

    }//end init()


    /**
     * 获取当前用户背词本所有单词id
     *
     * @return mixed
     */
    public function getCurrentUserReciteWordIds()
    {
        $query = "SELECT words_id FROM {$this->$tablePrefix}recite
                  WHERE uid = $this->uid AND act != 0";
        return $this->wpDb->get_results($query, ARRAY_A);

    }//end getCurrentUserReciteWordIds()


}//end class

?>