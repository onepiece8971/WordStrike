<?php
class study
{

    private $uid;

    public function __construct()
    {
        if (empty($this->uid)) {
            $current_user = wp_get_current_user();
            $this->uid = $current_user->ID;
        }
    }
    /**
     * 随机获取生词本中一个未背的单词.
     *
     * @param $books_id
     * @return mixed
     */
    public function randOneWord($books_id)
    {
        if (empty($books_id)) {
            $books_id = 1;
        }
        global $wpdb;
        //取出背词表的所有words_ids, 并拼接为字符串
        $query_recite = "SELECT words_id FROM ".Wordstrike::$table_prefix."recite WHERE uid = ".$this->uid." AND act != 0";
        $words_ids = $wpdb->get_results($query_recite, ARRAY_A);
        $words_ids = Wordstrike::getArrayValues($words_ids, 'words_id');
        $count = count($words_ids);
        $words_ids = implode(', ', $words_ids);
        if ($count == 0) { //没有已背单词
            $query_words_id = "SELECT words_id FROM ".Wordstrike::$table_prefix."words_books_words WHERE books_id = ".$books_id." ORDER BY rand() limit 1";
        } else {
            $query_words_id = "SELECT words_id FROM ".Wordstrike::$table_prefix."words_books_words WHERE books_id = ".$books_id." AND words_id NOT IN (".$words_ids.") ORDER BY rand() limit 1";
        }
        $words_id = $wpdb->get_var($query_words_id);
        //取得一个单词信息
        $query_one = "SELECT id, word_name, means, part, phonetic, voice FROM ".Wordstrike::$table_prefix."words WHERE id = ".$words_id;
        return $wpdb->get_row($query_one, ARRAY_A);
    }

    /**
     * 返回我的背词本中是否存在该单词.
     *
     * @param $words_id
     * @return bool
     */
    public function isMyRecite($words_id)
    {
        global $wpdb;
        $query = "SELECT * FROM ".Wordstrike::$table_prefix."recite WHERE words_id = ".$words_id." AND uid = ".$this->uid;
        $result = $wpdb->get_row($query);
        return empty($result);
    }

    /**
     * 添加单词到背词本.
     *
     * @param $words_id
     * @param $level
     * @return mixed
     */
    public function addRecite($words_id, $level = 1)
    {
        global $wpdb;
        if ($this->isMyRecite($words_id)) {
            return $wpdb->insert(
                Wordstrike::$table_prefix."recite",
                array('words_id' => $words_id, 'uid' => $this->uid, 'level' => $level, 'create_time' => time(), 'update_time' => time(), 'act' => 1),
                array('%d', '%d', '%d', '%d', '%d', '%d')
            );
        } else {
            return $wpdb->update(
                Wordstrike::$table_prefix."recite",
                array('act' => 1, 'level' => $level),
                array('words_id' => $words_id, 'uid' => $this->uid),
                array('%d', '%d'),
                array('%d', '%d')
            );
        }
    }

    public function getOneReviewWord()
    {
        //todo 随机一组复习单词
        global $wpdb;
        $query = "SELECT id, word_name, means, part, phonetic, voice FROM ".Wordstrike::$table_prefix."words WHERE id = ".$words_id;
        return $wpdb->get_results($query, ARRAY_A);
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