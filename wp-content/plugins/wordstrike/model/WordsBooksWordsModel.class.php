<?php
/**
 * 单词与单词本对应表
 *
 * PHP version 5.3
 *
 * @category  WordsBooksWordsModel
 * @package   WordStrike
 * @author    chenglinz <onepiece8971@163.com>
 * @copyright 2015-2016 Squiz Pty Ltd (ABN 77 084 670 600)
 * @license   https://github.com/onepiece8971/WordStrike/licence.txt BSD Licence
 * @link      https://github.com/onepiece8971/WordStrike
 */

/**
 * Class WordsBooksWordsModel
 *
 * @category WordsBooksWordsModel
 * @package  WordStrike
 * @author   chenglinz <onepiece8971@163.com>
 * @license  https://github.com/onepiece8971/WordStrike/licence.txt BSD Licence
 * @link     https://github.com/onepiece8971/WordStrike
 */
class WordsBooksWordsModel extends BaseModel
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
            self::$tableName = $this->$tablePrefix.'words_books_words';
        }

        parent::__construct();

    }//end __construct()


    /**
     * 随机获取一个已背生词id
     *
     * @param int   $booksId  生词本id
     * @param array $wordsIds 已背单词列表
     *
     * @return mixed
     */
    public function randWordIdByBooksIdInWordsIds($booksId, $wordsIds)
    {
        $count    = count($wordsIds);
        $wordsIds = implode(', ', $wordsIds);
        // 没有已背单词.
        if ($count === 0) {
            $queryWordsId = 'SELECT words_id FROM '.self::$tableName.'
                             WHERE books_id = '.$booksId.' ORDER BY rand() limit 1';
        } else {
            $queryWordsId = 'SELECT words_id FROM '.self::$tableName.'
                             WHERE books_id = '.$booksId.'
                             AND words_id NOT IN ('.$wordsIds.') ORDER BY rand() limit 1';
        }

        return self::$wpDb->get_var($queryWordsId);

    }//end randWordIdByBooksIdInWordsIds()


    /**
     * 获取当前用户所有生词本单词
     *
     * @param array $booksIds 单词本id
     *
     * @return mixed
     */
    public function getAllWordsCount($booksIds)
    {
        $booksIds = implode(',', $booksIds);
        $query    = 'SELECT COUNT(DISTINCT words_id) FROM '.self::$tableName.'
                     where books_id IN ('.$booksIds.')';
        return self::$wpDb->get_var($query);

    }//end getAllWordsCount()


    /**
     * 插入数据到words_books_words表
     *
     * @param int $bookId 生词本id
     * @param int $wordId 单词id
     *
     * @return bool
     */
    public function insertWordsBooksWords($bookId, $wordId)
    {
        return self::$wpDb->insert(
            self::$tableName,
            array(
             'books_id' => $bookId,
             'words_id' => $wordId,
            ),
            array(
             '%d', '%d',
            )
        );

    }//end insertWordsBooksWords()


    /**
     * 通过booksId获取该生词本所有words_id.
     *
     * @param int $booksId 单词本id
     *
     * @return array
     */
    public function getWordsIdsByBooksId($booksId)
    {
        $query    = 'SELECT words_id FROM '.self::$tableName.'
                     WHERE books_id = '.$booksId;
        $wordsIds = self::$wpDb->get_results($query, ARRAY_A);
        return Utility::getArrayValues($wordsIds, 'words_id');

    }//end getWordsIdsByBooksId()


}//end class

?>