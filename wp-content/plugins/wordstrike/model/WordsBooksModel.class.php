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
     *批量上传单词时一组的个数
     */
    const N = 10;

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
            self::$tableName = self::$tablePrefix.'words_books';
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


    /**
     * 获取数据库里的生词本.
     *
     * @return mixed
     */
    public function getWordsBooks()
    {
        $query = 'SELECT id, name, content, img_url FROM '.self::$tableName.'
                  where act = 1 ORDER BY create_time desc';
        return self::$wpDb->get_results($query, ARRAY_A);

    }//end getWordsBooks()


    /**
     * 判断是否已经存在该生词本
     *
     * @param string $name 生词本名字
     *
     * @return bool
     */
    public function isEmptyWordsBook($name)
    {
        $query = 'SELECT * FROM '.self::$tableName.'
                  where name = "'.$name.'"';
        $row   = self::$wpDb->get_row($query);
        return empty($row);

    }//end isEmptyWordsBook()


    /**
     * 通过bookIds获取words_books
     *
     * @param array $bookIds 单词本id
     *
     * @return bool
     */
    public function getWordsBooksByUIds($bookIds)
    {
        $bookIds = implode(', ', $bookIds);
        $query   = 'SELECT id, name, content, img_url FROM '.self::$tableName.'
                    where id IN ('.$bookIds.') AND act = 1 ORDER BY create_time desc';
        return self::$wpDb->get_results($query, ARRAY_A);

    }//end getWordsBooksByUIds()


    /**
     * 获取文本中的单词.
     *
     * @return array|bool
     */
    public function getAddWords()
    {
        $p = @fopen(TEMPLATEPATH.'/books/book.txt', 'r');
        if ($p !== false) {
            $words = array();
            while (!feof($p)) {
                $word = Utility::trimWord(fgets($p));
                if (empty($word) === false) {
                    array_push($words, $word);
                }
            }

            fclose($p);
            return $words;
        } else {
            return false;
        }

    }//end getAddWords()


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
        if ($this->isEmptyWordsBook($name) === true) {
            return self::$wpDb->insert(
                self::$tableName,
                array(
                 'name'        => $name,
                 'content'     => $content,
                 'img_url'     => $imgUrl,
                 'create_time' => time(),
                ),
                array(
                 '%s', '%s', '%s', '%d',
                )
            );
        } else {
            if (empty($imgUrl) === true) {
                $up = array(
                       'content'     => $content,
                       'create_time' => time(),
                       'act'         => 1,
                      );
            } else {
                $up = array(
                       'content'     => $content,
                       'img_url'     => $imgUrl,
                       'create_time' => time(),
                       'act'         => 1,
                      );
            }

            return self::$wpDb->update(
                self::$tableName,
                $up,
                array('name' => $name),
                array(
                 '%s', '%s', '%s', '%d', '%d',
                ),
                array('%s')
            );
        }//end if

    }//end addWordsBook()


    /**
     * 获取全部生词本.
     *
     * @return array
     */
    public function getAllWordsBooks()
    {
        $query = 'SELECT id, name FROM '.self::$tableName.'
                  where act = 1';
        return self::$wpDb->get_results($query, ARRAY_A);

    }//end getAllWordsBooks()


}//end class

?>