<?php
declare(strict_types=1);
// 共通部分の読込
if (session_status() == PHP_SESSION_NONE) {
   session_start();
}
require_once(dirname(__DIR__) . "/library/database_access.php");
require_once(dirname(__DIR__) . "/library/logger.php");

if(mb_strtolower($_SERVER['REQUEST_METHOD']) === 'post') {
    date_default_timezone_set('Asia/Tokyo');
    $title = empty($_POST['title']) ? 'no title' : $_POST['title'];
    $isbn = empty($_POST['isbn']) ? '123-4-567890-12-1': $_POST['isbn'];
    $price = empty($_POST['price']) ? 1000: (int)$_POST['price'];
    $author = empty($_POST['author']) ? 'MT' : $_POST['author'];
    $publisher_name = empty($_POST['publisher_name']) ? 'てすと書店' : $_POST['publisher_name'];
    $created = empty($_POST['created']) ? date("Y-m-d").'T'.date("H:i:s") : $_POST['created'];
    DatabaseAccess::insert($title, $isbn, $price, $author, $publisher_name, $created);
    $id = DatabaseAccess::lastInsertId(); // 最後に追加されたIDを取得
    writeLog("【処理】ID:${id} 「${title}」追加");
    header('Location: /htdocs/book.php');
} else {
    require_once(dirname(__DIR__) . "/template/form.php");
}
?>