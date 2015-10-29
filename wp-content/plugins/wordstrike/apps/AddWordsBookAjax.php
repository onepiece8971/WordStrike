<?php
/**
 * 添加单词本ajax调用
 *
 * PHP version 5.3
 *
 * @category  AddWordsBook
 * @package   WordStrike
 * @author    chenglinz <onepiece8971@163.com>
 * @copyright 2015-2016 Squiz Pty Ltd (ABN 77 084 670 600)
 * @license   https://github.com/onepiece8971/WordStrike/licence.txt BSD Licence
 * @link      https://github.com/onepiece8971/WordStrike
 */

/**
 * Class AddWordsBook
 *
 * @category AddWordsBook
 * @package  WordStrike
 * @author   chenglinz <onepiece8971@163.com>
 * @license  https://github.com/onepiece8971/WordStrike/licence.txt BSD Licence
 * @link     https://github.com/onepiece8971/WordStrike
 */
class AddWordsBookAjax
{


    /**
     * 分步导入生词本.
     *
     * @return void
     */
    public function importWordsBook()
    {
        if (empty($_POST) === true || check_ajax_referer('WordStrike', false, false) === false) {
            echo 'You targeted the right function, but sorry, your nonce did not verify.';
            die();
        } else {
            $arr = importWordsBookForSteps(intval($_POST['books_id']), intval($_POST['i']));
            echo json_encode($arr);
            die();
        }

    }//end importWordsBook()


    /**
     * 添加空生词本
     *
     * @return void
     */
    public function addWordsBook()
    {
        if (empty($_POST) === true || check_ajax_referer('WordStrike', false, false) === false) {
            echo 'You targeted the right function, but sorry, your nonce did not verify.';
            die();
        } else {
            $result = addWordsBook(trim($_POST['name']), trim($_POST['content']), trim($_POST['img_url']));
            echo intval($result);
            die();
        }

    }//end addWordsBook()


}//end class

add_action('wp_ajax_import_words_book', array('AddWordsBookAjax', 'importWordsBook'));
add_action('wp_ajax_add_words_book', array('AddWordsBookAjax', 'addWordsBook'));