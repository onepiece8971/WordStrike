<?php
class wordsBooks
{
    /**
     * 获取数据库里的生词本.
     *
     * @return mixed
     */
    public function getWordsBooks()
    {
        global $wpdb;
        $query = "SELECT id, name FROM ".Wordstrike::$table_prefix."words_books where act = 1 ORDER BY create_time desc";
        return $wpdb->get_results($query, ARRAY_A);
    }

    /**
     * 判断用户是否已添加相应生词本
     *
     * @param $uid
     * @param $bookId
     * @return bool
     */
    public function isMyWordsBook($uid,  $bookId)
    {
        global $wpdb;
        $query = "SELECT * FROM ".Wordstrike::$table_prefix."user_words_books where act = 1 and books_id = ".$bookId." and uid = ".$uid;
        $row = $wpdb->get_row($query);
        return empty($row);
    }
}

function getWordsBooks()
{
    $wordsBooks = new wordsBooks;
    return $wordsBooks->getWordsBooks();
}

function isMyWordsBook($uid, $bookId)
{
    $wordsBooks = new wordsBooks;
    return $wordsBooks->isMyWordsBook($uid, $bookId);
}