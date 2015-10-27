<?php
/**
 * 学习相关
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
 * Class Study
 *
 * @category Study
 * @package  WordStrike
 * @author   chenglinz <onepiece8971@163.com>
 * @license  https://github.com/onepiece8971/WordStrike/licence.txt BSD Licence
 * @link     https://github.com/onepiece8971/WordStrike
 */
class Study extends Base
{


    /**
     * 随机获取生词本中一个未背的单词
     *
     * @param int $booksId 生词本id
     *
     * @return mixed
     */
    public function randOneWord($booksId)
    {
        if (empty($booksId) === true) {
            $booksId = 1;
        }

        // 取出背词表的所有wordsIds, 并拼接为字符串.
        $wordsIds = ReciteModel::init()->getCurrentUserReciteWordIds();
        $wordsIds = Utility::getArrayValues($wordsIds, 'words_id');

        $wordsId = WordsBooksWordsModel::init()->randWordIdByBooksIdInWordsIds($booksId, $wordsIds);
        // 取得一个单词信息.
        return WordsModel::init()->getWordById($wordsId);

    }//end randOneWord()


    /**
     * 添加单词到背词本.
     *
     * @param int $wordsId 单词id
     * @param int $level   单词等级
     *
     * @return mixed
     */
    public function addRecite($wordsId, $level=1)
    {
        return ReciteModel::init()->addRecite($wordsId, $level);

    }//end addRecite()


    /**
     * 获取一个需要复习或大于开始学习时间的生词.
     *
     * @param int $begin 开始学习的时间
     *
     * @return mixed
     */
    public function getOneReviewWord($begin=0)
    {
        return ReciteModel::init()->getOneReviewWord($begin);

    }//end getOneReviewWord()


    /**
     * 升级单词.
     *
     * @param int $wordsId 单词id
     *
     * @return mixed
     */
    public function upgradeReciteWord($wordsId)
    {
        return ReciteModel::init()->upgradeReciteWord($wordsId);

    }//end upgradeReciteWord()


    /**
     * 忘记单词.
     *
     * @param int $wordsId 单词id.
     *
     * @return mixed
     */
    public function forgetReciteWord($wordsId)
    {
        return ReciteModel::init()->forgetReciteWord($wordsId);

    }//end forgetReciteWord()


    /**
     * 获取当前用户今天已背单词数.
     *
     * @return null|string
     */
    public function getTodayReciteWordCount()
    {
        return ReciteModel::init()->getTodayReciteWordCount();

    }//end getTodayReciteWordCount()


}//end class

?>