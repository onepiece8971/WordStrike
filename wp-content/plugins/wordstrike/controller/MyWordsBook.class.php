<?php
/**
 * 我的生词本
 *
 * PHP version 5.3
 *
 * @category  MyWordsBook
 * @package   WordStrike
 * @author    chenglinz <onepiece8971@163.com>
 * @copyright 2015-2016 Squiz Pty Ltd (ABN 77 084 670 600)
 * @license   https://github.com/onepiece8971/WordStrike/licence.txt BSD Licence
 * @link      https://github.com/onepiece8971/WordStrike
 */

/**
 * Class MyWordsBook
 *
 * @category WordStrike
 * @package  WordStrike
 * @author   chenglinz <onepiece8971@163.com>
 * @license  https://github.com/onepiece8971/WordStrike/licence.txt BSD Licence
 * @link     https://github.com/onepiece8971/WordStrike
 */
class MyWordsBook extends Base
{


    /**
     * 获取我得生词本
     *
     * @return array|bool
     */
    public function getMyWordsBooks()
    {
        $booksIds = UserWordsBooksModel::init()->getMyWordsBookIds();
        if (empty($booksIds) === false) {
            return WordsBooksModel::init()->getWordsBooksByBookIds($booksIds);
        } else {
            return false;
        }

    }//end getMyWordsBooks()


    /**
     * 获取已背非熟词个数
     *
     * @return int
     */
    public function getNewWordsCount()
    {
        return intval(ReciteModel::init()->getWordsCount());

    }//end getNewWordsCount()


    /**
     * 获取所有已背生词个数.
     *
     * @return int
     */
    public function getAllReciteWordsCount()
    {
        return intval(ReciteModel::init()->getWordsCount(2));

    }//end getAllReciteWordsCount()


    /**
     * 获取当前用户所有生词本单词.
     *
     * @return int
     */
    public function getAllWordsCount()
    {
        $booksIds = UserWordsBooksModel::init()->getMyWordsBookIds();
        return intval(WordsBooksWordsModel::init()->getAllWordsCount($booksIds));

    }//end getAllWordsCount()


}//end class

?>