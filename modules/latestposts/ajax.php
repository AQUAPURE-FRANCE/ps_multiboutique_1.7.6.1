<?php
// http://localhost:8000/modules/latestposts/ajax.php

$params = require_once('../../app/config/parameters.php');
require_once('../../config/config.inc.php');
require_once('../../init.php');

$host = $params['parameters']['database_host'];
$user = $params['parameters']['database_user'];
$pass = $params['parameters']['database_password'];
$databaseName = $params['parameters']['database_name'];
$_PREFIX_ = $params['parameters']['database_prefix'];

$connection = new mysqli($host, $user, $pass, $databaseName);
$connection->set_charset("utf8");

function formatDate($date)
{
    return date('g:i a', strtotime($date));
}

// Get user language based on browser language
$userLangIsoCode = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2);
$query = 'SELECT '.$_PREFIX_.'lang.id_lang, '.$_PREFIX_.'lang.iso_code FROM '.$_PREFIX_.'lang';
$userLang = $connection->query($query)->fetch_assoc();

// The three latest posts
$posts = [
    'latestThree' =>
        'SELECT DISTINCT '.$_PREFIX_.'smart_blog_post.created,
            '.$_PREFIX_.'smart_blog_post.id_smart_blog_post,
            '.$_PREFIX_.'smart_blog_post.id_author,
            '.$_PREFIX_.'employee.firstname,
            '.$_PREFIX_.'employee.lastname,
            '.$_PREFIX_.'smart_blog_post_lang.id_smart_blog_post,
            '.$_PREFIX_.'smart_blog_post_lang.meta_title,
            '.$_PREFIX_.'smart_blog_post_lang.short_description,
            '.$_PREFIX_.'smart_blog_post_lang.link_rewrite,
            '.$_PREFIX_.'lang.iso_code
        FROM '.$_PREFIX_.'smart_blog_post
        JOIN '.$_PREFIX_.'smart_blog_post_lang ON '.$_PREFIX_.'smart_blog_post.id_smart_blog_post = '.$_PREFIX_.'smart_blog_post_lang.id_smart_blog_post
        JOIN '.$_PREFIX_.'employee ON '.$_PREFIX_.'smart_blog_post.id_author = '.$_PREFIX_.'employee.id_employee
        JOIN '.$_PREFIX_.'lang ON '.$_PREFIX_.'lang.id_lang = '.$_PREFIX_.'smart_blog_post_lang.id_lang
        WHERE '.$_PREFIX_.'smart_blog_post.active = true AND '.$_PREFIX_.'lang.id_lang = '.(!is_null($userLang['id_lang']) ? $userLang['id_lang'] : 1).'
        ORDER BY '.$_PREFIX_.'smart_blog_post.created DESC
        LIMIT 3',

// The most viewed post
    'mostViewed' =>
        'SELECT DISTINCT '.$_PREFIX_.'smart_blog_post_lang.meta_title,
           '.$_PREFIX_.'smart_blog_post.id_smart_blog_post,
           '.$_PREFIX_.'smart_blog_post.id_author,
           '.$_PREFIX_.'employee.firstname,
           '.$_PREFIX_.'employee.lastname,
           '.$_PREFIX_.'smart_blog_post_lang.short_description,
           '.$_PREFIX_.'smart_blog_comment.created,
           '.$_PREFIX_.'smart_blog_post_lang.link_rewrite,
           '.$_PREFIX_.'lang.iso_code,
           (SELECT COUNT('.$_PREFIX_.'smart_blog_comment.id_post) FROM '.$_PREFIX_.'smart_blog_comment) AS comment_num,
           '.$_PREFIX_.'smart_blog_post.viewed
        FROM '.$_PREFIX_.'smart_blog_post
        JOIN '.$_PREFIX_.'employee ON '.$_PREFIX_.'smart_blog_post.id_author = '.$_PREFIX_.'employee.id_employee
        JOIN '.$_PREFIX_.'smart_blog_post_lang ON '.$_PREFIX_.'smart_blog_post.id_smart_blog_post = '.$_PREFIX_.'smart_blog_post_lang.id_smart_blog_post
        JOIN '.$_PREFIX_.'lang ON '.$_PREFIX_.'lang.id_lang = '.$_PREFIX_.'smart_blog_post_lang.id_lang
        JOIN '.$_PREFIX_.'smart_blog_comment ON '.$_PREFIX_.'smart_blog_post.id_smart_blog_post = '.$_PREFIX_.'smart_blog_comment.id_post
        WHERE '.$_PREFIX_.'smart_blog_post.active = true AND '.$_PREFIX_.'lang.id_lang = '.(!is_null($userLang['id_lang']) ? $userLang['id_lang'] : 1).'
        ORDER BY '.$_PREFIX_.'smart_blog_post.viewed DESC
        LIMIT 2',

// The last commented post
    'lastCommented' =>
        'SELECT '.$_PREFIX_.'smart_blog_post_lang.meta_title,
           '.$_PREFIX_.'smart_blog_post_lang.short_description,
           '.$_PREFIX_.'smart_blog_post_lang.link_rewrite,
           '.$_PREFIX_.'smart_blog_post.id_smart_blog_post,
           '.$_PREFIX_.'smart_blog_post.id_author,
           '.$_PREFIX_.'employee.firstname,
           '.$_PREFIX_.'employee.lastname,
           '.$_PREFIX_.'smart_blog_comment.created,
           '.$_PREFIX_.'lang.iso_code,
           '.$_PREFIX_.'smart_blog_post.viewed,
           COUNT(*) AS comment_num
        FROM '.$_PREFIX_.'smart_blog_post
        JOIN '.$_PREFIX_.'employee ON '.$_PREFIX_.'smart_blog_post.id_author = '.$_PREFIX_.'employee.id_employee
        JOIN '.$_PREFIX_.'smart_blog_post_lang ON '.$_PREFIX_.'smart_blog_post.id_smart_blog_post = '.$_PREFIX_.'smart_blog_post_lang.id_smart_blog_post
        JOIN '.$_PREFIX_.'smart_blog_comment ON '.$_PREFIX_.'smart_blog_post.id_smart_blog_post = '.$_PREFIX_.'smart_blog_comment.id_post
        JOIN '.$_PREFIX_.'lang ON '.$_PREFIX_.'lang.id_lang = '.$_PREFIX_.'smart_blog_post_lang.id_lang
        WHERE '.$_PREFIX_.'smart_blog_post.active = true AND '.$_PREFIX_.'lang.id_lang = '.(!is_null($userLang['id_lang']) ? $userLang['id_lang'] : 1).'
        GROUP by '.$_PREFIX_.'smart_blog_comment.id_post
        ORDER BY '.$_PREFIX_.'smart_blog_comment.created DESC
        LIMIT 1',

// The most commented post
    'mostCommented' =>
        'SELECT '.$_PREFIX_.'smart_blog_post_lang.meta_title,
           '.$_PREFIX_.'smart_blog_post_lang.short_description,
           '.$_PREFIX_.'smart_blog_post_lang.link_rewrite,
           '.$_PREFIX_.'smart_blog_post.id_smart_blog_post,
           '.$_PREFIX_.'smart_blog_post.id_author,
           '.$_PREFIX_.'employee.firstname,
           '.$_PREFIX_.'employee.lastname,
           '.$_PREFIX_.'smart_blog_comment.created,
           '.$_PREFIX_.'lang.iso_code,
           '.$_PREFIX_.'smart_blog_post.viewed,
           COUNT(*) AS comment_num
        FROM '.$_PREFIX_.'smart_blog_post
        JOIN '.$_PREFIX_.'employee ON '.$_PREFIX_.'smart_blog_post.id_author = '.$_PREFIX_.'employee.id_employee
        JOIN '.$_PREFIX_.'smart_blog_post_lang ON '.$_PREFIX_.'smart_blog_post.id_smart_blog_post = '.$_PREFIX_.'smart_blog_post_lang.id_smart_blog_post
        JOIN '.$_PREFIX_.'smart_blog_comment ON '.$_PREFIX_.'smart_blog_post.id_smart_blog_post = '.$_PREFIX_.'smart_blog_comment.id_post
        JOIN '.$_PREFIX_.'lang ON '.$_PREFIX_.'lang.id_lang = '.$_PREFIX_.'smart_blog_post_lang.id_lang
        WHERE '.$_PREFIX_.'smart_blog_post.active = true AND '.$_PREFIX_.'lang.id_lang = '.(!is_null($userLang['id_lang']) ? $userLang['id_lang'] : 1).'',
];

$latestThree = [];
$request = $connection->query($posts['latestThree']);
while ($row = $request->fetch_assoc()) {
    array_push($latestThree, $row);
}

$mostViewed = [];
$request = $connection->query($posts['mostViewed']);
while ($row = $request->fetch_assoc()) {
    array_push($mostViewed, $row);
}

echo json_encode(
    [
        'latest' => $latestThree,
        'mostViewed' => $mostViewed,
        'lastCommented' => $connection->query($posts['lastCommented'])->fetch_assoc(),
        'mostCommented' => $connection->query($posts['mostCommented'])->fetch_assoc(),
        'userLang' => $userLang
    ], JSON_PRETTY_PRINT
);




