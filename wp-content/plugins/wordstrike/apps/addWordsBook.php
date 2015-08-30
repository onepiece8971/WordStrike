<?php
function add_words_book()
{
    if (empty($_POST) || !check_ajax_referer('WordStrike', false, false)) {
        echo 'You targeted the right function, but sorry, your nonce did not verify.';
        die();
    } else {
        $arr = addWordsBook(1, (int)$_POST['i']);
        echo json_encode($arr);
        die();
    }
}

add_action('wp_ajax_add_words_book', 'add_words_book');