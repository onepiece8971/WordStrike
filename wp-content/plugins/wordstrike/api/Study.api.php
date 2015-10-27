<?php
/**
 * 学习相关的对外方法
 *
 * PHP version 5.3
 *
 * @category  Study
 * @package   WordStrike
 * @author    chenglinz <onepiece8971@163.com>
 * @copyright 2015-2016 Squiz Pty Ltd (ABN 77 084 670 600)
 * @license   https://github.com/onepiece8971/WordStrike/licence.txt BSD Licence
 * @link      https://github.com/onepiece8971/WordStrike
 */


/**
 * 随机获取生词本中一个未背的单词
 *
 * @return mixed
 */
function randOneWord()
{
    return Study::init()->randOneWord($_GET['b']);

}//end randOneWord()


/**
 * 添加单词到背词本.
 *
 * @param int $wordsId 单词id
 * @param int $level   单词等级
 *
 * @return mixed
 */
function addRecite($wordsId, $level=1)
{
    return Study::init()->addRecite($wordsId, $level);

}//end addRecite()


/**
 * 获取一个需要复习的生词.
 *
 * @return mixed
 */
function getOneReviewWord()
{
    return Study::init()->getOneReviewWord();

}//end getOneReviewWord()


/**
 * 升级单词.
 *
 * @param int $wordsId 单词id
 *
 * @return mixed
 */
function upgradeReciteWord($wordsId)
{
    return Study::init()->upgradeReciteWord($wordsId);

}//end upgradeReciteWord()


/**
 * 忘记单词.
 *
 * @param int $wordsId 单词id.
 *
 * @return mixed
 */
function forgetReciteWord($wordsId)
{
    return Study::init()->forgetReciteWord($wordsId);

}//end forgetReciteWord()


/**
 * 获取当前用户今天已背单词数.
 *
 * @return null|string
 */
function getTodayReciteWordCount()
{
    return Study::init()->getTodayReciteWordCount();

}//end getTodayReciteWordCount()