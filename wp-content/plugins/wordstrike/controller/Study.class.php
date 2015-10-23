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
     * @param $words_id
     * @return mixed
     */
    public function forgetReciteWord($words_id)
    {
        global $wpdb;
        $level = $this->getLevelById($words_id);
        $level = 0 === $level ? -1 : 0;
        return $wpdb->update(
            Wordstrike::$table_prefix."recite",
            array('update_time' => time(), 'level' => $level, 'level_time' => self::$level[$level]),
            array('words_id' => $words_id, 'uid' => $this->uid),
            array('%d', '%d', '%d'),
            array('%d', '%d')
        );
    }

    /**
     * 获取当前用户今天已背单词数.
     *
     * @return null|string
     */
    public function getTodayReciteWordCount()
    {
        global $wpdb;
        $today = strtotime("today");
        $query = "SELECT count(1) FROM {$this->$tablePrefix}recite WHERE uid = ".$this->uid."  AND create_time >= ".$today." AND act = 1";
        return $wpdb->get_var($query);
    }
}

function randOneWord()
{
    $study = new study;
    return $study->randOneWord($_GET['b']);
}

function addRecite($words_id, $level = 1)
{
    $study = new study;
    return $study->addRecite($words_id, $level);
}

function getOneReviewWord()
{
    $study = new study;
    return $study->getOneReviewWord();
}

function upgradeReciteWord($words_id)
{
    $study = new study;
    return $study->upgradeReciteWord($words_id);
}

function forgetReciteWord($words_id)
{
    $study = new study;
    return $study->forgetReciteWord($words_id);
}

function getTodayReciteWordCount()
{
    $study = new study;
    return $study->getTodayReciteWordCount();
}