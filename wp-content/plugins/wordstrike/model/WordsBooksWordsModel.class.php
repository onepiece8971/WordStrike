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
     * 实例化类
     *
     * @return object
     */
    public static function init()
    {
        return parent::instance(__CLASS__);

    }//end init()


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
            $queryWordsId = "SELECT words_id FROM {$this->$tablePrefix}words_books_words
                             WHERE books_id = $booksId ORDER BY rand() limit 1";
        } else {
            $queryWordsId = "SELECT words_id FROM {$this->$tablePrefix}words_books_words
                             WHERE books_id = $booksId
                             AND words_id NOT IN ($wordsIds) ORDER BY rand() limit 1";
        }

        return $this->wpDb->get_var($queryWordsId);

    }//end randWordIdByBooksIdInWordsIds()


}//end class

?>