<?php
/**
 * 单词表
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
 * Class WordsBooksModel
 *
 * @category WordsModel
 * @package  WordStrike
 * @author   chenglinz <onepiece8971@163.com>
 * @license  https://github.com/onepiece8971/WordStrike/licence.txt BSD Licence
 * @link     https://github.com/onepiece8971/WordStrike
 */
class WordsBooksModel extends BaseModel
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
            self::$tableName = $this->$tablePrefix.'words_books';
        }

        parent::__construct();

    }//end __construct()


    /**
     * 通过bookIds获取words_books
     *
     * @param array $bookIds 单词本id
     *
     * @return array
     */
    public function getWordsBooksByBookIds($bookIds)
    {
        $bookIds = implode(', ', $bookIds);
        $query   = 'SELECT id, name, content, img_url FROM '.self::$tableName.'
                    where id IN ('.$bookIds.') AND act = 1 ORDER BY create_time desc';
        return self::$wpDb->get_results($query, ARRAY_A);

    }//end getWordsBooksByBookIds()


}//end class

?>