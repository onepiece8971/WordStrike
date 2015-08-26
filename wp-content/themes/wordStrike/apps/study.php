<?php

function add_my_recite()
{
    if (empty($_POST) || !check_ajax_referer('WordStrike', false, false)) {
        echo 'You targeted the right function, but sorry, your nonce did not verify.';
        die();
    } else {
        echo addRecite($_POST['words_id'], $_POST['level']);
//            echo "add";
        die();
    }
}

add_action('wp_ajax_add_my_recite', 'add_my_recite');