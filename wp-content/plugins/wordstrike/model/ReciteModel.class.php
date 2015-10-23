<?php
/**
 * 复习表
 *
 * PHP version 5.3
 *
 * @category  ReciteModel
 * @package   WordStrike
 * @author    chenglinz <onepiece8971@163.com>
 * @copyright 2015-2016 Squiz Pty Ltd (ABN 77 084 670 600)
 * @license   https://github.com/onepiece8971/WordStrike/licence.txt BSD Licence
 * @link      https://github.com/onepiece8971/WordStrike
 */

/**
 * Class ReciteModel
 *
 * @category ReciteModel
 * @package  WordStrike
 * @author   chenglinz <onepiece8971@163.com>
 * @license  https://github.com/onepiece8971/WordStrike/licence.txt BSD Licence
 * @link     https://github.com/onepiece8971/WordStrike
 */
class ReciteModel extends BaseModel
{

    /**
     * 表名
     *
     * @var string
     */
    public static $tableName;

    /**
     * 单词等级
     *
     * @var array
     */
    public static $level = array(
                            -1 => 30,
                            0  => 60,
                            1  => 300,
                            2  => 1800,
                            3  => 43200,
                            4  => 86400,
                            5  => 172800,
                            6  => 345600,
                            7  => 604800,
                            8  => 1296000,
                            9  => 2592000,
                           );


    /**
     * 初始化参数
     */
    public function __construct()
    {
        if (empty(self::$tableName) === true) {
            self::$tableName = $this->$tablePrefix.'recite';
        }

        parent::__construct();

    }//end __construct()


    /**
     * 获取当前用户背词本所有单词id
     *
     * @return mixed
     */
    public function getCurrentUserReciteWordIds()
    {
        $query = 'SELECT words_id FROM '.self::$tableName.'
                  WHERE '.self::$uid.' AND act != 0';
        return self::$wpDb->get_results($query, ARRAY_A);

    }//end getCurrentUserReciteWordIds()


    /**
     * 返回我的背词本中是否存在该单词.
     *
     * @param int $wordsId 单词id
     *
     * @return bool
     */
    public function existMyRecite($wordsId)
    {
        $query = 'SELECT * FROM '.self::$tableName.'
                  WHERE words_id = '.$wordsId.' AND uid = '.self::$uid;
        return $this->exists($query);

    }//end existMyRecite()


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
        if ($this->existMyRecite($wordsId) === true) {
            $this->insertRecite($wordsId, $level);
        } else {
            $this->updateLevelFromRecite($wordsId, $level);
        }//end if

    }//end addRecite()


    /**
     * 插入背词表
     *
     * @param int $wordsId 单词id
     * @param int $level   等级
     *
     * @return mixed
     */
    public function insertRecite($wordsId, $level=1)
    {
        return self::$wpDb->insert(
            self::$tableName,
            array(
             'words_id'    => $wordsId,
             'uid'         => self::$uid,
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

    }//end insertRecite()


    /**
     * 更新背词等级
     *
     * @param int $wordsId 单词id
     * @param int $level   等级
     *
     * @return mixed
     */
    public function updateLevelFromRecite($wordsId, $level=1)
    {
        return self::$wpDb->update(
            self::$tableName,
            array(
             'act'         => 1,
             'level'       => $level,
             'level_time'  => self::$level[$level],
             'update_time' => time(),
            ),
            array(
             'words_id' => $wordsId,
             'uid'      => self::$uid,
            ),
            array(
             '%d', '%d', '%d', '%d',
            ),
            array(
             '%d', '%d',
            )
        );

    }//end updateLevelFromRecite()


    /**
     * 获取一个需要复习的生词.
     *
     * @param int $begin 开始学习的时间
     *
     * @return mixed
     */
    public function getOneReviewWord($begin=0)
    {
        $now = time();
        if (empty($begin) === true) {
            $query = 'SELECT words_id FROM '.self::$tableName.'
                      WHERE uid = '.self::$uid.' AND '.$now.' - update_time >= level_time AND act = 1
                      order by update_time LIMIT 1';
        } else {
            $query = 'SELECT words_id FROM '.self::$tableName.'
                      WHERE uid = '.self::$uid.' AND '.$now.' - update_time >= level_time AND create_time > '.$begin.' AND act = 1
                      order by update_time LIMIT 1';
        }

        $wordsId = self::$wpDb->get_var($query);
        return WordsModel::init()->getWordById($wordsId);

    }//end getOneReviewWord()


    /**
     * 获取当前用户的一个单词等级
     *
     * @param int $wordsId 单词id
     *
     * @return mixed
     */
    public function getLevelById($wordsId)
    {
        $query = 'SELECT `level` FROM '.self::$tableName.'
                  WHERE words_id = '.$wordsId.' AND uid = '.self::$uid.' AND act = 1';
        return intval(self::$wpDb->get_var($query));

    }//end getLevelById()


    /**
     * 升级单词.
     *
     * @param int $wordsId 单词id
     *
     * @return mixed
     */
    public function upgradeReciteWord($wordsId)
    {
        // 获取单词当前等级.
        $level = $this->getLevelById($wordsId);
        if (9 === $level) {
            $level = 9;
        } else {
            ++$level;
        }

        return self::$wpDb->update(
            self::$tableName,
            array(
             'level'       => $level,
             'level_time'  => self::$level[$level],
             'update_time' => time(),
            ),
            array(
             'words_id' => $wordsId,
             'uid'      => $this->uid,
            ),
            array(
             '%d', '%d', '%d',
            ),
            array(
             '%d', '%d',
            )
        );

    }//end upgradeReciteWord()


}//end class

?>