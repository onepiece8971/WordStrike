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
 * 获取数据库里的生词本.
 *
 * @return mixed
 */
function getWordsBooks()
{
    return WordsBooks::init()->getWordsBooks();

}//end getWordsBooks()


/**
 * 判断用户是否已添加相应生词本
 *
 * @param int $bookId 单词本id
 *
 * @return bool
 */
function isMyWordsBook($bookId)
{
    return WordsBooks::init()->isMyWordsBook($bookId);

}//end isMyWordsBook()


/**
 * 删除用户生词本(静态删除)
 *
 * @param int $bookId 单词本id
 *
 * @return bool
 */
function delMyWordsBook($bookId)
{
    return WordsBooks::init()->delMyWordsBook($bookId);

}//end delMyWordsBook


/**
 * 添加生词本, 如果存在则更新act=1,不存在则insert
 *
 * @param int $bookId 单词本id
 *
 * @return mixed
 */
function addMyWordsBook($bookId)
{
    return WordsBooks::init()->addMyWordsBook($bookId);

}//end addMyWordsBook()


/**
 * 分步导入生词本.
 *
 * @param int $bookId 单词本id
 * @param int $i      计数号
 *
 * @return array
 */
function importWordsBookForSteps($bookId, $i)
{
    return WordsBooks::init()->importWordsBookForSteps($bookId, $i);

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
function addWordsBook($name, $content, $imgUrl)
{
    return WordsBooks::init()->addWordsBook($name, $content, $imgUrl);

}//end addWordsBook()


/**
 * 获取全部生词本.
 *
 * @return array
 */
function getAllWordsBooks()
{
    return WordsBooks::init()->getAllWordsBooks();

}

