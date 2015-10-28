<?php
/**
 * 用户单词表
 *
 * PHP version 5.3
 *
 * @category  WordsModel
 * @package   WordStrike
 * @author    chenglinz <onepiece8971@163.com>
 * @copyright 2015-2016 Squiz Pty Ltd (ABN 77 084 670 600)
 * @license   https://github.com/onepiece8971/WordStrike/licence.txt BSD Licence
 * @link      https://github.com/onepiece8971/WordStrike
 */

/**
 * Class UserWordsBooksModel
 *
 * @category WordsModel
 * @package  WordStrike
 * @author   chenglinz <onepiece8971@163.com>
 * @license  https://github.com/onepiece8971/WordStrike/licence.txt BSD Licence
 * @link     https://github.com/onepiece8971/WordStrike
 */
class UserWordsBooksModel extends BaseModel
{

    /**
     * @var string 表名
     */
    public static $tableName;


    /**
     * 初始化参数
     */
    public function __construct()
    {
        if (empty(self::$tableName) === true) {
            self::$tableName = $this->$tablePrefix.'user_words_books';
        }

        parent::__construct();

    }//end __construct()


    /**
     * 获取我得生词本
     *
     * @return array
     */
    public function getMyWordsBookIds()
    {
        $query    = 'SELECT books_id FROM '.self::$tableName.'
                     where uid = '.self::$uid.' AND act = 1';
        $booksIds = self::$wpDb->get_results($query, ARRAY_A);
        return Utility::getArrayValues($booksIds, 'books_id');

    }//end getMyWordsBookIds()


}//end class

?>