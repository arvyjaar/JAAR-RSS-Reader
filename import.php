<?php
/** This script imports RSS feed to Database. For CLI use.
*   Usage: php import.php [url] [category]
**/

require_once ("Xmlparser.php");

// Get parameters passed to CLI and do basic validation
$err = "Usage: php import.php [url] [category].\nRequired two parameters: 1) RSS full URL address 2) Category string.\n";
if(!isset($argv[1]) || !isset($argv[2]))
    exit($err);
if (filter_var($argv[1], FILTER_VALIDATE_URL) === false)
    exit($err."Not a valid URL given.\n");

$url = $argv[1];
$category = filter_var($argv[2], FILTER_SANITIZE_STRING);

date_default_timezone_set(TIMEZONE);

// Parse XML and insert into database
$xml = new Xmlparser();
$xml->import($url, $category);