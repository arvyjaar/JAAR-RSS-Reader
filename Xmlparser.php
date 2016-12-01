<?php

/**
 * Parses XML content
 */
require_once("DbBase.php");

class Xmlparser extends DbModel
{
    /**
     * Iterates XML, deals with unwanted white spaces
     * @param Object
     * @return array
     */
    private function _whitespaces_fairy($xmlObject)
    {
        $itemList = array();
        for ($i = 0; $i < $xmlObject->length; $i++) {
            foreach ($xmlObject->item($i)->childNodes as $eachChild) {
                if ($eachChild->nodeType == 1) // ensure nodeType is Element
                    $itemList[$i][$eachChild->nodeName] = $eachChild->nodeValue;
            }
        }
        return $itemList;
    }

    /**
     * Get RSS data and insert into database
     */
    public function import($url, $category)
    {
        $xmlDoc = new DOMDocument();
        $xmlDoc->load($url);
        $xmlDoc->normalize();

        // Get RSS title, url, etc & insert into "feeds" table, return last insert id
        $xmlObject = $xmlDoc->getElementsByTagName('channel');
        $itemList = $this->_whitespaces_fairy($xmlObject);
        echo "Inserted feed ID: " . $rss_id = $this->insert_feed([$itemList[0]['title'], $itemList[0]['link'], $category, date('Y-m-d H:i:s')]);

        // Get RSS items data and insert into table "items"
        $xmlObject = $xmlDoc->getElementsByTagName('item');
        $itemList = $this->_whitespaces_fairy($xmlObject);
        foreach ($itemList as $item) {
            $pubDate = date('Y-m-d H:i:s', strtotime($item['pubDate']));
            $arr = [$item['title'], $pubDate, $item['link'], $item['description'], $rss_id];
            echo "Inserted item id: " . $this->insert_item($arr);
        }
    }
};