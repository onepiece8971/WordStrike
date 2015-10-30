<?php
/**
 * 我的单词本ajax调用
 *
 * PHP version 5.3
 *
 * @category  StudyAjax
 * @package   WordStrike
 * @author    chenglinz <onepiece8971@163.com>
 * @copyright 2015-2016 Squiz Pty Ltd (ABN 77 084 670 600)
 * @license   https://github.com/onepiece8971/WordStrike/licence.txt BSD Licence
 * @link      https://github.com/onepiece8971/WordStrike
 */

/**
 * Class StudyAjax
 *
 * @category StudyAjax
 * @package  WordStrike
 * @author   chenglinz <onepiece8971@163.com>
 * @license  https://github.com/onepiece8971/WordStrike/licence.txt BSD Licence
 * @link     https://github.com/onepiece8971/WordStrike
 */
class StudyAjax
{


    /**
     * 加入背词本
     *
     * @return void
     */
    public static function addMyRecite()
    {
        if (empty($_POST) === true || check_ajax_referer('WordStrike', false, false) === false) {
            echo 'You targeted the right function, but sorry, your nonce did not verify.';
            die();
        } else {
            echo addRecite($_POST['words_id'], $_POST['level']);
            die();
        }

    }//end addMyRecite()


    /**
     * 更新背词本
     *
     * @return void
     */
    public static function upgradeMyRecite()
    {
        if (empty($_POST) === true || check_ajax_referer('WordStrike', false, false) === false) {
            echo 'You targeted the right function, but sorry, your nonce did not verify.';
            die();
        } else {
            if ($_POST['type'] === 'upgrade') {
                echo upgradeReciteWord($_POST['words_id']);
            } else if ($_POST['type'] === 'forget') {
                echo forgetReciteWord($_POST['words_id']);
            }

            die();
        }

    }//end upgradeMyRecite()


}//end class

add_action('wp_ajax_add_my_recite', array('StudyAjax', 'addMyRecite'));
add_action('wp_ajax_upgrade_my_recite', array('StudyAjax', 'upgradeMyRecite'));