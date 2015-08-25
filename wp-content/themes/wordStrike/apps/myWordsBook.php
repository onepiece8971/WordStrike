<?php
class myWordsBook
{
    public function del_my_words_book() {
        if (empty($_POST) || !check_ajax_referer('WordStrike', false, false)) {
//        if (empty($_POST) || !wp_verify_nonce($_POST['WordStrike'], 'add_transfer')) {
            echo 'You targeted the right function, but sorry, your nonce did not verify.';
            die();
        } else {
            echo delMyWordsBook($_POST['uid'], $_POST['books_id']);
//            echo 'del';
            die();
        }
    }

    public function add_my_words_book() {
        if (empty($_POST) || !check_ajax_referer('WordStrike', false, false)) {
//        if (empty($_POST) || !wp_verify_nonce($_POST['WordStrike'], 'add_transfer')) {
            echo 'You targeted the right function, but sorry, your nonce did not verify.';
            die();
        } else {
            echo addMyWordsBook($_POST['uid'], $_POST['books_id']);
//            echo "add";
            die();
        }
    }
}

add_action('wp_ajax_del_my_words_book', array('myWordsBook', 'del_my_words_book'));
add_action('wp_ajax_add_my_words_book', array('myWordsBook', 'add_my_words_book'));