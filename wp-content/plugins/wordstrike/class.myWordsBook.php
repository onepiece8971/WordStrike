<?php
class myWordsBook
{

    /**
     * 获取我得生词本
     *
     * @param $uid
     * @return array|mixed
     */
    public function getMyWordsBooks($uid)
    {
        global $wpdb;
        $wordsBooks = new wordsBooks;
        $query = "SELECT books_id FROM ".Wordstrike::$table_prefix."user_words_books where uid = ".$uid." AND act = 1";
        $books_ids = $wpdb->get_results($query, ARRAY_A);
        $books_ids = Wordstrike::getArrayValues($books_ids, 'books_id');
        if ($books_ids) {
            return $wordsBooks->getWordsBooksByUids($books_ids);
        } else {
            return false;
        }
    }

    /**
     * 获取已背生词个数
     *
     * @param bool $new 生词|熟词
     * @return null|string
     */
    public function getNewWordsCount($new = true)
    {
        global $wpdb;
        $level = $new ?  '!= 9' : '= 9';
        $current_user = wp_get_current_user();
        $uid = $current_user->ID;
        $query = "SELECT count(1) FROM ".Wordstrike::$table_prefix."recite where uid = ".$uid." AND level ".$level."  AND act = 1";
        return $wpdb->get_var($query);
    }

    /**
     * 获取所有已背生词个数.
     *
     * @return null|string
     */
    public function getAllReciteWordsCount()
    {
        global $wpdb;
        $current_user = wp_get_current_user();
        $uid = $current_user->ID;
        $query = "SELECT count(1) FROM ".Wordstrike::$table_prefix."recite where uid = ".$uid."  AND act = 1";
        return $wpdb->get_var($query);
    }

    /**
     * 获取当前用户所有生词本单词.
     *
     * @return null|string
     */
    public function getAllWordsCount()
    {
        global $wpdb;
        $current_user = wp_get_current_user();
        $uid = $current_user->ID;
        $query_my_words_books = "SELECT books_id FROM ".Wordstrike::$table_prefix."user_words_books where uid = ".$uid." AND act = 1";
        $my_words_books = $wpdb->get_results($query_my_words_books, ARRAY_A);
        $my_words_books = Wordstrike::getArrayValues($my_words_books, 'books_id');
        $my_words_books = implode(',', $my_words_books);
        $query = "SELECT COUNT(DISTINCT words_id) FROM ".Wordstrike::$table_prefix."words_books_words where books_id IN (".$my_words_books.")";
        $a = $wpdb->get_var($query);
        return $a;
    }
}

function getMyWordsBooks($uid)
{
    $wordsBooks = new myWordsBook;
    return $wordsBooks->getMyWordsBooks($uid);
}

function getNewWordsCount($new = true)
{
    $wordsBooks = new myWordsBook;
    return $wordsBooks->getNewWordsCount($new);
}

function getUnstudiedCount()
{
    $wordsBooks = new myWordsBook;
    return $wordsBooks->getAllWordsCount() - $wordsBooks->getAllReciteWordsCount();
}
