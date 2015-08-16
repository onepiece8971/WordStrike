<?php
class study
{
    public function getUserWordsBook($books_id)
    {
        if (empty($books_id)) {
            $books_id = 1;
        }
        global $wpdb;
        $querystr = "SELECT words_id FROM ".Wordstrike::$table_prefix."words_books_words where books_id = ".$books_id." order by rand() limit 1";
        $words_id = $wpdb->get_var($querystr);
        $queryword = "SELECT * FROM ".Wordstrike::$table_prefix."words where id = ".$words_id;
        return $wpdb->get_row($queryword, ARRAY_A);
    }
}

function getUserWordsBook()
{
    $study = new study;
    return $study->getUserWordsBook($_GET['books_id']);
}