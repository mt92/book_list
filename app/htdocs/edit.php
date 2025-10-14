<?php
declare(strict_types=1);
require_once(dirname(__DIR__) . "/library/database_access.php");

if(mb_strtolower($_SERVER['REQUEST_METHOD']) === 'post') { //「POST」「post」に対応
    if (isset($_POST['detail'])) { // JSON形式の書籍データを連想配列としてデコード
        $data = json_decode($_POST['detail'], true);
        $id = $data['id'];
        // DateTimeオブジェクトを作成し、指定された日時文字列を解析する
        $dateTime = new DateTime($data['created']);
        // date()関数を使用して、datetime-local形式の文字列に変換する
        $formattedDateTime = $dateTime->format('Y-m-d\TH:i');
        require_once(dirname(__DIR__) . "/template/edit.php");
    } else {
        $data = json_decode($_POST['data'], true);
        $id = (string)$data['id']; // IDはJSONに入っている
        // フォームから送られた各項目を取得
        $title = $_POST['title'] ?? '';
        $isbn = $_POST['isbn'] ?? '';
        $price = $_POST['price'] ?? '';
        $author = $_POST['author'] ?? '';
        $publisher_name = $_POST['publisher_name'] ?? '';
        $created = $_POST['created'] ?? '';
        // DateTimeオブジェクトを作成し、指定された日時文字列を解析する
        $dateTime = new DateTime($created);
        // date()関数を使用して、datetime-local形式の文字列に変換する
        $formattedDateTime = $dateTime->format('Y-m-d\TH:i');
        DatabaseAccess::update($id, $title, $isbn, (int)$price, $author, $publisher_name, $formattedDateTime);        
        require_once(dirname(__DIR__) . "/htdocs/book.php");
    }
}
?>