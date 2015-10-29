<?php
/**
 * 生词
 *
 * PHP version 5.3
 *
 * @category  Words
 * @package   WordStrike
 * @author    chenglinz <onepiece8971@163.com>
 * @copyright 2015-2016 Squiz Pty Ltd (ABN 77 084 670 600)
 * @license   https://github.com/onepiece8971/WordStrike/licence.txt BSD Licence
 * @link      https://github.com/onepiece8971/WordStrike
 */

/**
 * Class Words
 *
 * @category WordStrike
 * @package  WordStrike
 * @author   chenglinz <onepiece8971@163.com>
 * @license  https://github.com/onepiece8971/WordStrike/licence.txt BSD Licence
 * @link     https://github.com/onepiece8971/WordStrike
 */
class Words extends Base
{


    /**
     * 通过wordName判断word是否存在(不管是否激活)
     *
     * @param string $wordName 单词名
     *
     * @return bool
     */
    public function isEmptyWordName($wordName)
    {
        return WordsModel::init()->isEmptyWordName($wordName);

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
        return WordsModel::init()->getWordByWordName($wordName);

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
        return WordsModel::init()->insertOneWord($wordName, $phonetic, $means);

    }//end insertOneWord()


    /**
     * 批量添加单词
     *
     * @param string $words 单词
     *
     * @return bool
     */
    public function addWords($words)
    {
        if (empty($words) === false) {
            WordsModel::init()->addWords($words);
            return true;
        } else {
            return false;
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
        return WordsModel::init()->getWordByWordsNameFromFile($wordName);

    }//end getWordByWordsNameFromFile()


}//end class

?>