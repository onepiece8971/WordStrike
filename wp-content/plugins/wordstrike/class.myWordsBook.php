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

}

function getMyWordsBooks($uid)
{
    $wordsBooks = new myWordsBook;
    return $wordsBooks->getMyWordsBooks($uid);
}
