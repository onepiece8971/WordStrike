<?php
/**
 * 我的单词本ajax调用
 *
 * PHP version 5.3
 *
 * @category  MyWordsBookAjax
 * @package   WordStrike
 * @author    chenglinz <onepiece8971@163.com>
 * @copyright 2015-2016 Squiz Pty Ltd (ABN 77 084 670 600)
 * @license   https://github.com/onepiece8971/WordStrike/licence.txt BSD Licence
 * @link      https://github.com/onepiece8971/WordStrike
 */

/**
 * Class MyWordsBookAjax
 *
 * @category MyWordsBookAjax
 * @package  WordStrike
 * @author   chenglinz <onepiece8971@163.com>
 * @license  https://github.com/onepiece8971/WordStrike/licence.txt BSD Licence
 * @link     https://github.com/onepiece8971/WordStrike
 */
class MyWordsBookAjax
{


    /**
     * 删除我的生词本
     *
     * @return bool
     */
    public static function delMyWordsBook()
    {
        if (empty($_POST) === true || check_ajax_referer('WordStrike', false, false) === false) {
            echo 'You targeted the right function, but sorry, your nonce did not verify.';
            die();
        } else {
            echo delMyWordsBook($_POST['uid'], $_POST['books_id']);
            die();
        }

    }//end delMyWordsBook()


    /**
     * 添加我的生词本
     *
     * @return bool
     */
    public static function addMyWordsBook()
    {
        if (empty($_POST) === true || check_ajax_referer('WordStrike', false, false) === false) {
            echo 'You targeted the right function, but sorry, your nonce did not verify.';
            die();
        } else {
            echo addMyWordsBook($_POST['uid'], $_POST['books_id']);
            die();
        }

    }//end addMyWordsBook()


    /**
     * 添加Session
     *
     * @return void
     */
    public static function addSession()
    {
        if (empty($_POST) === true || check_ajax_referer('WordStrike', false, false) === false) {
            echo 'You targeted the right function, but sorry, your nonce did not verify.';
            die();
        } else {
            if (isset($_SESSION) === false) {
                session_start();
            }

            $_SESSION['study_time'] = time();
            die();
        }

    }//end addSession()


}//end class

add_action('wp_ajax_del_my_words_book', array('MyWordsBookAjax', 'delMyWordsBook'));
add_action('wp_ajax_add_my_words_book', array('MyWordsBookAjax', 'delMyWordsBook'));
add_action('wp_ajax_add_session', array('MyWordsBookAjax', 'delMyWordsBook'));