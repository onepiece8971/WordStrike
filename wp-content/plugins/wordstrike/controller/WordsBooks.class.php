<?php
/**
 * 生词本
 *
 * PHP version 5.3
 *
 * @category  WordsBooks
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
class WordsBooks extends Base
{


    /**
     * 获取数据库里的生词本.
     *
     * @return mixed
     */
    public function getWordsBooks()
    {
        return WordsBooksModel::init()->getWordsBooks();

    }//end getWordsBooks()


    /**
     * 通过bookIds获取words_books
     *
     * @param int $bookIds 单词本id
     *
     * @return bool
     */
    public function getWordsBooksByUIds($bookIds)
    {
        if (is_array($bookIds) === false) {
            return false;
        }

        return WordsBooksModel::init()->getWordsBooksByUIds($bookIds);

    }//end getWordsBooksByUIds()


    /**
     * 判断用户是否已添加相应生词本
     *
     * @param int $bookId 单词本id
     * @param int $act    是否激活($act=1,0,null)
     *
     * @return bool
     */
    public function isMyWordsBook($bookId, $act=1)
    {
        return UserWordsBooksModel::init()->isMyWordsBook($bookId, $act);

    }//end isMyWordsBook()


    /**
     * 删除用户生词本(静态删除)
     *
     * @param int $bookId 单词本id
     *
     * @return bool
     */
    public function delMyWordsBook($bookId)
    {
        return UserWordsBooksModel::init()->delMyWordsBook($bookId);

    }//end delMyWordsBook()


    /**
     * 添加生词本, 如果存在则更新act=1,不存在则insert
     *
     * @param int $bookId 单词本id
     *
     * @return mixed
     */
    public function addMyWordsBook($bookId)
    {
        return UserWordsBooksModel::init()->addMyWordsBook($bookId);

    }//end addMyWordsBook()


    /**
     * 添加单词到生词本.
     *
     * @param int   $bookId 生词本id
     * @param array $words  单词组
     *
     * @return void
     */
    public function addWordsToWordsBook($bookId, $words)
    {
        if (Words::init()->addWords($words) === true) {
            $wordsIds = WordsBooksWordsModel::init()->getWordsIdsByBooksId($bookId);
            foreach ($words as $word) {
                $w = Words::init()->getWordByWordName($word);
                if (empty($w) === false && in_array($w['id'], $wordsIds) === false) {
                    WordsBooksWordsModel::init()->insertWordsBooksWords(
                        $bookId,
                        $w['id']
                    );
                }
            }
        }

    }//end addWordsToWordsBook()


    /**
     * 分步导入生词本.
     *
     * @param int $bookId 单词本id
     * @param int $i      计数号
     *
     * @return array
     */
    public function importWordsBookForSteps($bookId, $i=0)
    {
        $words = WordsBooksModel::init()->getAddWords();
        if ($words !== false) {
            return array(
                    'flag'    => 0,
                    'i'       => $i,
                    'percent' => 0,
                   );
        }

        set_time_limit(0);
        $count = count($words);
        if ($i >= $count) {
            return array(
                    'flag'    => 2,
                    'i'       => $i,
                    'percent' => 100,
                   );
        }

        $ei = ($i + self::N);

        if ($ei >= $count) {
            $words = array_slice($words, $i);
        } else {
            $words = array_slice($words, $i, self::N);
        }

        try {
            $this->addWordsToWordsBook($bookId, $words);
        } catch (Exception $e) {
            return array(
                    'flag'    => 0,
                    'i'       => $i,
                    'percent' => 0,
                   );
        }

        return array(
                'flag'    => 1,
                'i'       => $ei,
                'percent' => $i / $count * 100,
               );

    }//end importWordsBookForSteps()


    /**
     * 添加空生词本.
     *
     * @param string $name    生词本名称
     * @param string $content 描述
     * @param string $imgUrl  封面图片地址
     *
     * @return bool
     */
    public function addWordsBook($name, $content, $imgUrl)
    {
        return WordsBooksModel::init()->addWordsBook($name, $content, $imgUrl);

    }//end addWordsBook()


    /**
     * 获取全部生词本.
     *
     * @return array
     */
    public function getAllWordsBooks()
    {
        return WordsBooksModel::init()->getAllWordsBooks();

    }//end getAllWordsBooks()


}//end class
