<?php
class delMyWordsBook
{
    public function del_my_words_book() {
        if (empty($_POST) || !check_ajax_referer('WordStrike', false, false)) {
//        if (empty($_POST) || !wp_verify_nonce($_POST['WordStrike'], 'add_transfer')) {
            echo 'You targeted the right function, but sorry, your nonce did not verify.';
            die();
        } else {
            echo delMyWordsBook($_POST['uid'], $_POST['books_id']);
            die();
        }
    }
}

add_action('wp_ajax_del_my_words_book', array('delMyWordsBook', 'del_my_words_book'));