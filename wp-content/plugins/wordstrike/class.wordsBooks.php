<?php
class wordsBooksBack
{
    private static $n = 10;
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
     * @param int $act
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

    /**
     * 获取文本中的单词.
     *
     * @return array|bool
     */
    public function getAddWords()
    {
        $p = @fopen(TEMPLATEPATH."/books/book.txt", "r");
        if ($p) {
            $words = array();
            while (!feof($p)) {
                $word = Wordstrike::trim_word(fgets($p));
                if ($word) {
                    array_push($words, $word);
                }
            }
            fclose($p);
            return $words;
        } else {
            return false;
        }
    }

    /**
     * 分步导入生词本.
     *
     * @param $book_id
     * @param int $i
     * @return array
     */
    public function importWordsBookForSteps($book_id, $i = 0)
    {
        $words = $this->getAddWords();
        if (!$words) {
            return array('flag'=> 0, 'i' => $i, 'percent' => 0);
        }
        set_time_limit(0);
        $count = count($words);
        if ($i >= $count) {
            return array('flag'=> 2, 'i' => $i, 'percent' => 100);
        }
        $ei = $i + self::$n;
        if ($ei >= $count) {
            $words = array_slice($words, $i);
        } else {
            $words = array_slice($words, $i, self::$n);
        }
        try {
            $this->addWordsToWordsBook($book_id, $words);
        } catch (Exception $e) {
            return array('flag'=> 0, 'i' => $i, 'percent' => 0);
        }
        return array('flag'=> 1, 'i' => $ei, 'percent' => $i  / $count * 100);
    }

    /**
     * 添加单词到生词本.
     *
     * @param $book_id
     * @param $words
     */
    public function addWordsToWordsBook($book_id, $words)
    {
        global $wpdb;
        $ob_words = new words;
        if ($ob_words->addWords($words)) {
            $words_ids = $this->getWordsIdsByBooksId($book_id);
            foreach ($words as $word) {
                $w = $ob_words->getWordByWordName($word);
                if ($w && !in_array($w['id'], $words_ids)) {
                    $wpdb->insert(
                        Wordstrike::$table_prefix . 'words_books_words',
                        array(
                            'books_id' => $book_id,
                            'words_id' => $w['id']
                        ),
                        array('%d', '%d')
                    );
                }
            }
        }
    }

    /**
     * 通过books_id获取该生词本所有words_id.
     *
     * @param $books_id
     * @return array
     */
    public function getWordsIdsByBooksId($books_id)
    {
        global $wpdb;
        $query = "SELECT words_id FROM ".Wordstrike::$table_prefix."words_books_words WHERE books_id = ".$books_id;
        $words_ids = $wpdb->get_results($query, ARRAY_A);
        return Wordstrike::getArrayValues($words_ids, 'words_id');
    }

    /**
     * 添加空生词本.
     *
     * @param $name
     * @param $content
     * @param $img_url
     * @return bool
     */
    public function addWordsBook($name, $content, $img_url)
    {
        global $wpdb;
        if ($this->isEmptyWordsBook($name)) {
            return $wpdb->insert(
                Wordstrike::$table_prefix."words_books",
                array('name' => $name, 'content' => $content, 'img_url' => $img_url, 'create_time' => time()),
                array('%s', '%s', '%s', '%d')
            );
        } else {
            if (empty($img_url)) {
                $up = array('content' => $content, 'create_time' => time(), 'act' => 1);
            } else {
                $up = array('content' => $content, 'img_url' => $img_url, 'create_time' => time(), 'act' => 1);
            }
            return $wpdb->update(
                Wordstrike::$table_prefix."words_books",
                $up,
                array('name' => $name),
                array('%s', '%s', '%s', '%d', '%d'),
                array('%s')
            );
        }
    }

    /**
     * 是否已经存在该生词本
     *
     * @param $name
     * @return bool
     */
    public function isEmptyWordsBook($name)
    {
        global $wpdb;
        $query = "SELECT * FROM ".Wordstrike::$table_prefix."words_books where name = '".$name."'";
        $row = $wpdb->get_row($query);
        return empty($row);
    }

    /**
     * 获取全部生词本.
     *
     * @return mixed
     */
    public function getAllWordsBooks()
    {
        global $wpdb;
        $query = "SELECT id, name FROM ".Wordstrike::$table_prefix."words_books where act = 1";
        return $wpdb->get_results($query, ARRAY_A);
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

function importWordsBookForSteps($book_id, $i)
{
    $wordsBooks = new wordsBooks;
    return $wordsBooks->importWordsBookForSteps($book_id, $i);
}

function addWordsBook($name, $content, $img_url)
{
    $wordsBooks = new wordsBooks;
    return $wordsBooks->addWordsBook($name, $content, $img_url);
}

function getAllWordsBooks()
{
    $wordsBooks = new wordsBooks;
    return $wordsBooks->getAllWordsBooks();
}