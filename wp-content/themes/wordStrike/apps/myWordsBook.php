<?php
function del_my_words_book()
{
    if (empty($_POST) || !check_ajax_referer('WordStrike', false, false)) {
        echo 'You targeted the right function, but sorry, your nonce did not verify.';
        die();
    } else {
        echo delMyWordsBook($_POST['uid'], $_POST['books_id']);
//            echo 'del';
        die();
    }
}

function add_my_words_book()
{
    if (empty($_POST) || !check_ajax_referer('WordStrike', false, false)) {
        echo 'You targeted the right function, but sorry, your nonce did not verify.';
        die();
    } else {
        echo addMyWordsBook($_POST['uid'], $_POST['books_id']);
//            echo "add";
        die();
    }
}

function add_session()
{
    if (empty($_POST) || !check_ajax_referer('WordStrike', false, false)) {
        echo 'You targeted the right function, but sorry, your nonce did not verify.';
        die();
    } else {
        if(!isset($_SESSION)) {
            session_start();
        }
        $_SESSION['study_time'] = time();
        die();
    }
}

add_action('wp_ajax_del_my_words_book', 'del_my_words_book');
add_action('wp_ajax_add_my_words_book', 'add_my_words_book');
add_action('wp_ajax_add_session', 'add_session');