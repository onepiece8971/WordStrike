<?php
function import_words_book()
{
    if (empty($_POST) || !check_ajax_referer('WordStrike', false, false)) {
        echo 'You targeted the right function, but sorry, your nonce did not verify.';
        die();
    } else {
        $arr = importWordsBookForSteps((int)$_POST['books_id'], (int)$_POST['i']);
        echo json_encode($arr);
        die();
    }
}

function add_words_book()
{
    if (empty($_POST) || !check_ajax_referer('WordStrike', false, false)) {
        echo 'You targeted the right function, but sorry, your nonce did not verify.';
        die();
    } else {
        echo (int)addWordsBook(trim($_POST['name']), trim($_POST['content']), trim($_POST['img_url']));
        die();
    }
}

add_action('wp_ajax_import_words_book', 'import_words_book');
add_action('wp_ajax_add_words_book', 'add_words_book');