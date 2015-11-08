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
     * 错误生词
     *
     * @var array
     */
    public static $errorWords = array();


    /**
     * 初始化参数
     */
    public function __construct()
    {
        if (empty(self::$tableName) === true) {
            self::$tableName = self::$tablePrefix.'words';
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


    /**
     * 通过wordName判断word是否存在(不管是否激活)
     *
     * @param string $wordName 单词名
     *
     * @return bool
     */
    public function isEmptyWordName($wordName)
    {
        $query = 'SELECT * FROM '.self::$tableName.'
                  WHERE word_name = "'.$wordName.'"';
        $one   = self::$wpDb->get_row($query);
        return empty($one);

    }//end isEmptyWordName()


    /**
     * 通过wordName获取word
     *
     * @param string $wordName 单词名
     *
     * @return mixed
     */
    public function getWordByWordName($wordName)
    {
        $query = 'SELECT id, word_name, means, part, phonetic, voice FROM '.self::$tableName.'
                  WHERE word_name = "'.$wordName.'" AND act = 1';
        return self::$wpDb->get_row($query, ARRAY_A);

    }//end getWordByWordName()


    /**
     * 插入新词
     *
     * @param string $wordName 单词名
     * @param string $phonetic 英标
     * @param array  $means    意思
     *
     * @return bool
     */
    public function insertOneWord($wordName, $phonetic, array $means)
    {
        $part  = array_keys($means);
        $means = json_encode($means);
        return self::$wpDb->insert(
            self::$tableName,
            array(
             'word_name' => $wordName,
             'phonetic'  => $phonetic,
             'means'     => $means,
             'part'      => implode(',', $part),
            )
        );

    }//end insertOneWord()


    /**
     * 批量添加单词
     *
     * @param array $words 单词
     *
     * @return void
     */
    public function addWords($words)
    {
        foreach ($words as $wordName) {
            if ($this->isEmptyWordName($wordName) === true) {
                $word = $this->getWordByWordsNameFromFile($wordName);
                if (empty($word) === false) {
                    $flag = $this->insertOneWord($word['word_name'], $word['phonetic'], $word['means']);
                    if ($flag === false) {
                        array_push(self::$errorWords, $word);
                    }
                } else {
                    array_push(self::$errorWords, $word);
                }
            }
        }

    }//end addWords()


    /**
     * 通过wordName从接口获取单词.
     *
     * @param string $wordName 单词名
     *
     * @return array
     */
    public function getWordByWordsNameFromFile($wordName)
    {
        $word = file_get_contents(WORDSTRIKE_API.$wordName);
        $word = json_decode($word, true);
        return $word['data'];

    }//end getWordByWordsNameFromFile()


}//end class

?>