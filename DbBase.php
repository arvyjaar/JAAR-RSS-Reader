<?php
/**
 * Database operations
 */
require_once("Db.php");

class DbBase
{

    public function __construct()
    {
        $db = Db::getInstance();
        $this->_dbh = $db->getConnection();
    }

    /**
     * Insert row into table feeds and get inserted row id
     * @param array
     * @return integer
     */
    public function insert_feed($arr)
    {
        try {
            $this->_dbh->prepare("INSERT INTO feeds (title, url, category, last_update) VALUES (?, ?, ?, ?)")->execute($arr);
            return $this->_dbh->lastInsertId() . "\n";
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    /**
     * Insert row into table items
     * @param array
     * @return integer
     */
    public function insert_item($arr)
    {
        try {
            $this->_dbh->prepare("INSERT INTO items (title, published, link, description, feed_id) VALUES (?, ?, ?, ?, ?)")->execute($arr);
            return $this->_dbh->lastInsertId() . "\n";
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    /**
     * Query string selector
     * @param string
     * @return string
     */
    private function _arr($arr){
        if(isset($arr) && $arr !== null) {
            return "SELECT ff.id, ff.url, ff.last_update, ff.title AS name, COUNT( its.feed_id ) AS cc_count, its.title, its.link
                  FROM feeds AS ff
                  INNER JOIN items AS its ON its.feed_id = ff.id WHERE ?=ff.category
                  GROUP BY feed_id
                  ORDER BY its.published DESC 
                  LIMIT 0 , 30";
        }
        else return "SELECT ff.id, ff.url, ff.last_update, ff.title AS name, COUNT( its.feed_id ) AS cc_count, its.title, its.link
                  FROM feeds AS ff
                  INNER JOIN items AS its ON its.feed_id = ff.id
                  GROUP BY feed_id
                  ORDER BY its.published DESC 
                  LIMIT 0 , 30";
    }

    /**
     * Select feeds with items by category
     * @param string
     * @return array
     */
    public function select_feeds($arr = null)
    {
        $query = $this->_arr($arr);
        $arr = array($arr);
        $stmt = $this->_dbh->prepare($query);
        $stmt->execute($arr);
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $data;
    }
}