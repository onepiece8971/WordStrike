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


    /**
     * 添加生词本, 如果存在则更新act=1,不存在则insert
     *
     * @param int $bookId 单词本id
     *
     * @return mixed
     */
    public function addMyWordsBook($bookId)
    {
        if ($this->isMyWordsBook($bookId, null) === true) {
            return self::$wpDb->insert(
                self::$tableName,
                array(
                 'books_id'    => $bookId,
                 'uid'         => self::$uid,
                 'act'         => 1,
                 'create_time' => time(),
                ),
                array(
                 '%d', '%d', '%d',
                )
            );
        } else {
            return self::$wpDb->update(
                self::$tableName,
                array('act' => 1),
                array(
                 'books_id' => $bookId,
                 'uid'      => self::$uid,
                ),
                array('%d'),
                array(
                 '%d', '%d',
                )
            );
        }//end if

    }//end addMyWordsBook()


    /**
     * 判断用户是否已添加相应生词本
     *
     * @param int $bookId 单词本id
     * @param int $act    是否激活
     *
     * @return bool
     */
    public function isMyWordsBook($bookId, $act=1)
    {
        if (null === $act) {
            $query = 'SELECT * FROM '.self::$tableName.'
                      where books_id = '.$bookId.' and uid = '.self::$uid;
        } else {
            $query = 'SELECT * FROM '.self::$tableName.'
                      where act = '.$act.' and books_id = '.$bookId.' and uid = '.self::$uid;
        }

        $row = self::$wpDb->get_row($query);
        return empty($row);

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
        return self::$wpDb->update(
            self::$tableName,
            array('act' => 0),
            array(
             'books_id' => $bookId,
             'uid'      => self::$uid,
            ),
            array('%d'),
            array(
             '%d', '%d',
            )
        );

    }//end delMyWordsBook()


}//end class

?>