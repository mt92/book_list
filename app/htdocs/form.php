<?php
declare(strict_types=1);
require_once(dirname(__DIR__) . "/library/common.php");

$priceError = $_SESSION['priceError'] ?? '';
$isbnError = $_SESSION['isbnError'] ?? '';

if(mb_strtolower($_SERVER['REQUEST_METHOD']) === 'post') {
    date_default_timezone_set('Asia/Tokyo');
    $title = empty($_POST['title']) ? 'no title' : $_POST['title'];
    $isbn = empty($_POST['isbn']) ? '123-4-567890-12-1': $_POST['isbn'];
    $isbnError = validateCheck($isbn, "isbn");
    $price = empty($_POST['price']) ? 1000 : $_POST['price'];
    $priceError = validateCheck($price, "isnum");
    $author = empty($_POST['author']) ? 'MT' : $_POST['author'];
    $publisher_name = empty($_POST['publisher_name']) ? 'てすと書店' : $_POST['publisher_name'];
    $created = empty($_POST['created']) ? date("Y-m-d").'T'.date("H:i:s") : $_POST['created'];
    
    if(!$priceError && !$isbnError) {
        $isbn = isbnFormat($isbn);
        $price = (int)$price;
        DatabaseAccess::insert($title, $isbn, $price, $author, $publisher_name, $created);
        $id = DatabaseAccess::lastInsertId(); // 最後に追加されたIDを取得
        writeLog("【処理】ID:${id} 「${title}」追加");
        header('Location: /htdocs/book.php');
    } else {
        if($isbnError) {
            $_SESSION['isbnError'] = $isbnError;
        }
        if($priceError) {
            $_SESSION['priceError'] = $priceError;
        }
        require_once(dirname(__DIR__) . "/template/form.php");
        unset($_SESSION['isbnError']);
        unset($_SESSION['priceError']);
    }
} else {
    require_once(dirname(__DIR__) . "/template/form.php");
}
?>