<?php
class study
{
    public function getUserWordsBook($books_id)
    {
        if (empty($books_id)) {
            $books_id = 1;
        }
        global $wpdb;
        $query_id = "SELECT words_id FROM ".Wordstrike::$table_prefix."words_books_words WHERE books_id = ".$books_id." ORDER BY rand() limit 1";
        $words_id = $wpdb->get_var($query_id);
        $queryid_word = "SELECT word_name, means, part, phonetic, voice FROM ".Wordstrike::$table_prefix."words WHERE id = ".$words_id;
        return $wpdb->get_row($queryid_word, ARRAY_A);
    }
}

function getUserWordsBook()
{
    $study = new study;
    return $study->getUserWordsBook($_GET['books_id']);
}