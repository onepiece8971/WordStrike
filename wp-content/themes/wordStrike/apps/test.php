<?php

class test
{
    public function process_add_transfer() {
        if (empty($_POST) || !check_ajax_referer('WordStrike', false, false)) {
//        if (empty($_POST) || !wp_verify_nonce($_POST['WordStrike'], 'add_transfer')) {
            echo 'You targeted the right function, but sorry, your nonce did not verify.';
            die();
        } else {
            // do your function here
            echo 'http://www.baidu.com';
            die();
        }
    }
}

add_action('wp_ajax_add_transfer', array('test', 'process_add_transfer'));