<?php
/**
 * 我的生词本方法
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
 * 获取我得生词本
 *
 * @return array|bool
 */
function getMyWordsBooks()
{
    return MyWordsBook::init()->getMyWordsBooks();

}//end getMyWordsBooks()


/**
 * 获取已背非熟词个数
 *
 * @return int
 */
function getNewWordsCount()
{
    return MyWordsBook::init()->getNewWordsCount();

}//end getNewWordsCount()


/**
 * 获取未背单词个数
 *
 * @return int
 */
function getUnstudiedCount()
{
    $allWordsCount = MyWordsBook::init()->getAllWordsCount();
    $allReciteWordsCount = MyWordsBook::init()->getAllReciteWordsCount();
    return $allWordsCount - $allReciteWordsCount;
}