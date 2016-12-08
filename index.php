<?php
require_once "Twig/lib/Twig/Autoloader.php";
Twig_Autoloader::register();

require_once "DbBase.php";

$loader = new Twig_Loader_Filesystem('templates');
$twig = new Twig_Environment($loader, array(//'cache' => 'compilation_cache',
));

$feeds = new DbBase();
$arr = (isset($_GET['category']) && $_GET['category'] !=="") ? $_GET['category'] : null;
$feeds = $feeds->selectFeeds($arr);

echo $twig->render('content.html', array(
        'page_title' => 'JAAR RSS Reader',
        'feeds' => $feeds,
        'arr' => $arr
    ));