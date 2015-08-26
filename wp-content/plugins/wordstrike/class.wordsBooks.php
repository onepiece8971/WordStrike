<?php
class wordsBooks
{
    /**
     * 获取数据库里的生词本.
     *
     * @return mixed
     */
    public function getWordsBooks()
    {
        global $wpdb;
        $query = "SELECT id, name, content, img_url FROM ".Wordstrike::$table_prefix."words_books where act = 1 ORDER BY create_time desc";
        return $wpdb->get_results($query, ARRAY_A);
    }

    /**
     * 通过book_ids获取words_books
     *
     * @param $book_ids
     * @return bool
     */
    public function getWordsBooksByUids($book_ids)
    {
        if (!is_array($book_ids)) {
            return false;
        }
        $book_ids = implode(', ', $book_ids);
        global $wpdb;
        $query = "SELECT id, name, content, img_url FROM ".Wordstrike::$table_prefix."words_books where id IN (".$book_ids.") AND act = 1 ORDER BY create_time desc";
        return $wpdb->get_results($query, ARRAY_A);
    }

    /**
     * 判断用户是否已添加相应生词本
     *
     * @param $uid
     * @param $bookId
     * @return bool
     */
    public function isMyWordsBook($uid,  $bookId, $act = 1)
    {
        global $wpdb;
        $query = "SELECT * FROM ".Wordstrike::$table_prefix."user_words_books where act = ".$act." and books_id = ".$bookId." and uid = ".$uid;
        if (null === $act) {
            $query = "SELECT * FROM ".Wordstrike::$table_prefix."user_words_books where books_id = ".$bookId." and uid = ".$uid;
        }
        $row = $wpdb->get_row($query);
        return empty($row);
    }

    /**
     * 删除用户生词本(静态删除)
     *
     * @param $uid
     * @param $bookId
     * @return mixed
     */
    public function delMyWordsBook($uid,  $bookId)
    {
        global $wpdb;
        return $wpdb->update(
            Wordstrike::$table_prefix."user_words_books",
            array('act' => 0),
            array('books_id' => $bookId, 'uid' => $uid),
            array('%d'),
            array('%d', '%d')
            );
    }

    /**
     * 添加生词本, 如果存在则更新act=1,不存在则insert
     *
     * @param $uid
     * @param $bookId
     * @return mixed
     */
    public function addMyWordsBook($uid,  $bookId)
    {
        global $wpdb;
        if ($this->isMyWordsBook($uid,  $bookId, null)) {
            return $wpdb->insert(
                Wordstrike::$table_prefix."user_words_books",
                array('books_id' => $bookId, 'uid' => $uid, 'act' => 1, 'create_time' => time()),
                array('%d', '%d', '%d')
            );
        } else {
            return $wpdb->update(
                Wordstrike::$table_prefix."user_words_books",
                array('act' => 1),
                array('books_id' => $bookId, 'uid' => $uid),
                array('%d'),
                array('%d', '%d')
            );
        }
    }
}

function getWordsBooks()
{
    $wordsBooks = new wordsBooks;
    return $wordsBooks->getWordsBooks();
}

function isMyWordsBook($uid, $bookId)
{
    $wordsBooks = new wordsBooks;
    return $wordsBooks->isMyWordsBook($uid, $bookId);
}

function delMyWordsBook($uid, $bookId)
{
    $wordsBooks = new wordsBooks;
    return $wordsBooks->delMyWordsBook($uid, $bookId);
}

function addMyWordsBook($uid, $bookId)
{
    $wordsBooks = new wordsBooks;
    return $wordsBooks->addMyWordsBook($uid, $bookId);
}