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

function upgrade_my_recite()
{
    if (empty($_POST) || !check_ajax_referer('WordStrike', false, false)) {
        echo 'You targeted the right function, but sorry, your nonce did not verify.';
        die();
    } else {
        if ($_POST['type'] == 'upgrade') {
            echo upgradeReciteWord($_POST['words_id']);
        } elseif ($_POST['type'] == 'forget') {
            echo forgetReciteWord($_POST['words_id']);
        }
//            echo "upgrade";
        die();
    }
}

add_action('wp_ajax_add_my_recite', 'add_my_recite');
add_action('wp_ajax_upgrade_my_recite', 'upgrade_my_recite');