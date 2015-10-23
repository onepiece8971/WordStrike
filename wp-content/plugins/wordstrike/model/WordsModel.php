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
 * Class WordsModel
 *
 * @category WordsModel
 * @package  WordStrike
 * @author   chenglinz <onepiece8971@163.com>
 * @license  https://github.com/onepiece8971/WordStrike/licence.txt BSD Licence
 * @link     https://github.com/onepiece8971/WordStrike
 */
class WordsModel extends BaseModel
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
            self::$tableName = $this->$tablePrefix.'words';
        }

        parent::__construct();

    }//end __construct()


    /**
     * 通过words_id获取一个单词
     *
     * @param int $wordsId 单词id
     *
     * @return mixed
     */
    public function getWordById($wordsId)
    {
        $query = 'SELECT id, word_name, means, part, phonetic, voice
                  FROM '.self::$tableName.'
                  WHERE id = '.$wordsId.' AND act = 1';
        return self::$wpDb->get_row($query, ARRAY_A);

    }//end getWordById()


}//end class

?>