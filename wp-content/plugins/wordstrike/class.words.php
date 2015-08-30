<?php
class words
{
    /**
     * 通过word_name判断word是否存在
     * (不管是否激活)
     *
     * @param $word_name
     * @return bool
     */
    public function isWordByWordName($word_name)
    {
        global $wpdb;
        $query_one = "SELECT * FROM ".Wordstrike::$table_prefix."words WHERE word_name = '".$word_name."'";
        $one = $wpdb->get_row($query_one);
        return empty($one);
    }

    /**
     * 通过word_name获取word
     *
     * @param $word_name
     * @return mixed
     */
    public function getWordByWordName($word_name)
    {
        global $wpdb;
        $query_one = "SELECT id, word_name, means, part, phonetic, voice FROM ".Wordstrike::$table_prefix."words WHERE word_name = '".$word_name."' AND act = 1";
        return $wpdb->get_row($query_one, ARRAY_A);
    }

    /**
     * 插入新词
     *
     * @param $word_name
     * @param $phonetic
     * @param array $means
     * @return mixed
     */
    public function insertOneWord($word_name, $phonetic, array $means)
    {
        global $wpdb;
        $part = array_keys($means);
        $means = json_encode($means);
        return $wpdb->insert(
            Wordstrike::$table_prefix . 'words',
            array(
                'word_name' => $word_name,
                'phonetic' => $phonetic,
                'means' => $means,
                'part' => implode(',', $part),
            )
        );
    }

    /**
     * 批量添加单词
     *
     * @param $words
     * @return bool
     */
    public function addWords($words)
    {
        $url = 'http://localhost/WordStrikeApi/Public/?q=';
        if ($words) {
            foreach ($words as $word_name) {
                if ($this->isWordByWordName($word_name)) {
                    $word = file_get_contents($url.$word_name);
                    $word = json_decode($word, true);
                    $word = $word['data'];
                    if (!empty($word)) {
                        $flag = $this->insertOneWord($word['word_name'], $word['phonetic'], $word['means']);
                        if (!$flag) {
                            return $flag;
                        }
                    }
                }
            }
            return true;
        } else {
            return false;
        }
    }
}