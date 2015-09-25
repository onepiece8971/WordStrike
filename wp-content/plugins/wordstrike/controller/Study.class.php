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
     * 实例化类
     *
     * @return object
     */
    public static function init()
    {
        parent::instance(__CLASS__);

    }//end init()


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
        return $this->getWordById($wordsId);

    }//end randOneWord()


    /**
     * 返回我的背词本中是否存在该单词.
     *
     * @param int $wordsId 单词id
     *
     * @return bool
     */
    public function isMyRecite($wordsId)
    {
        $wpdb   = $GLOBALS['wpdb'];
        $query  = "SELECT * FROM {$this->$tablePrefix}recite
                   WHERE words_id = $wordsId AND uid = $this->uid";
        $result = $wpdb->get_row($query);
        return empty($result);

    }//end isMyRecite()


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
        $wpdb = $GLOBALS['wpdb'];
        if ($this->isMyRecite($wordsId) === true) {
            return $wpdb->insert(
                $this->$tablePrefix.'recite',
                array(
                 'words_id'    => $wordsId,
                 'uid'         => $this->uid,
                 'level'       => $level,
                 'level_time'  => self::$level[$level],
                 'create_time' => time(),
                 'update_time' => time(),
                 'act'         => 1,
                ),
                array(
                 '%d', '%d', '%d', '%d', '%d', '%d', '%d',
                )
            );
        } else {
            return $wpdb->update(
                $this->$tablePrefix.'recite',
                array(
                 'act'         => 1,
                 'level'       => $level,
                 'level_time'  => self::$level[$level],
                 'update_time' => time(),
                ),
                array(
                 'words_id' => $wordsId,
                 'uid'      => $this->uid,
                ),
                array(
                 '%d', '%d', '%d', '%d',
                ),
                array(
                 '%d', '%d',
                )
            );
        }//end if

    }//end addRecite()


    /**
     * 通过words_id获取一个单词
     *
     * @param int $wordsId 单词id
     *
     * @return mixed
     */
    public function getWordById($wordsId)
    {
        $wpdb     = $GLOBALS['wpdb'];
        $queryOne = "SELECT id, word_name, means, part, phonetic, voice
                     FROM {$this->$tablePrefix}words
                     WHERE id = $wordsId AND act = 1";
        return $wpdb->get_row($queryOne, ARRAY_A);

    }//end getWordById()


    /**
     * 获取一个需要复习的生词.
     *
     * @return mixed
     */
    public function getOneReviewWord()
    {
        $wpdb    = $GLOBALS['wpdb'];
        $now     = time();
        $query   = "SELECT words_id FROM {$this->$tablePrefix}recite
                           WHERE uid = $this->uid AND $now - update_time >= level_time AND act = 1
                           order by update_time LIMIT 1";
        $wordsId = $wpdb->get_var($query);
        return $this->getWordById($wordsId);

    }//end getOneReviewWord()


    /**
     * 获取一个大于开始学习时间的复习生词
     *
     * @param int $begin 开始学习的时间
     *
     * @return mixed
     */
    public function getOneReviewWordAfterBegin($begin)
    {
        $wpdb    = $GLOBALS['wpdb'];
        $now     = time();
        $query   = "SELECT words_id FROM {$this->$tablePrefix}recite
                        WHERE uid = $this->uid AND $now - update_time >= level_time AND create_time > $begin AND act = 1
                        order by update_time LIMIT 1";
        $wordsId = $wpdb->get_var($query);
        return $this->getWordById($wordsId);

    }//end getOneReviewWordAfterBegin()


    /**
     * 获取当前用户的一个单词等级
     *
     * @param $words_id
     * @return mixed
     */
    public function getLevelById($words_id)
    {
        global $wpdb;
        $query = "SELECT `level` FROM {$this->$tablePrefix}recite WHERE words_id = ".$words_id." AND uid = ".$this->uid." AND act = 1";
        return (int)$wpdb->get_var($query);
    }

    /**
     * 升级单词.
     *
     * @param $words_id
     * @return mixed
     */
    public function upgradeReciteWord($words_id)
    {
        global $wpdb;
        $level = $this->getLevelById($words_id); //获取单词当前等级
        if (9 == $level) {
            $level = 9;
        } else {
            ++$level;
        }
        return $wpdb->update(
            Wordstrike::$table_prefix."recite",
            array('level' => $level, 'level_time' => self::$level[$level], 'update_time' => time()),
            array('words_id' => $words_id, 'uid' => $this->uid),
            array('%d', '%d', '%d'),
            array('%d', '%d')
        );
    }

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

function getOneReviewWordAfterBegin($begin)
{
    $study = new study;
    return $study->getOneReviewWordAfterBegin($begin);
}

function getTodayReciteWordCount()
{
    $study = new study;
    return $study->getTodayReciteWordCount();
}