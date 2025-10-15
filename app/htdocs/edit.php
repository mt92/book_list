<?php
declare(strict_types=1);
require_once(dirname(__DIR__) . "/library/common.php");

$priceError = $_SESSION['priceError'] ?? '';
$isbnError = $_SESSION['isbnError'] ?? '';

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
        $isbnError = validateCheck($_POST['isbn'], "isbn");
        $priceError = validateCheck($_POST['price'], "isnum");
        
        if(!$priceError && !$isbnError) {
            // フォームから送られた各項目を取得
            $title = $_POST['title'] ?? '';
            $isbn = $_POST['isbn'] ?? '';
            $price = $_POST['price'] ?? '';
            $author = $_POST['author'] ?? '';
            $publisher_name = $_POST['publisher_name'] ?? '';
            $created = $_POST['created'] ?? '';
            $isbn = isbnFormat($isbn);
            $price = (int)$price;
            // DateTimeオブジェクトを作成し、指定された日時文字列を解析する
            $dateTime = new DateTime($created);
            // date()関数を使用して、datetime-local形式の文字列に変換する
            $formattedDateTime = $dateTime->format('Y-m-d\TH:i');
            DatabaseAccess::update($id, $title, $isbn, (int)$price, $author, $publisher_name, $formattedDateTime);
            writeLog("【処理】ID:${id} 「${title}」更新");
            header('Location: /htdocs/book_detail.php?id=' . $id);
        } else {
            if($isbnError) {
                $_SESSION['isbnError'] = $isbnError;
            }
            if($priceError) {
                $_SESSION['priceError'] = $priceError;
            }
            // DateTimeオブジェクトを作成し、指定された日時文字列を解析する
            $dateTime = new DateTime($data['created']);
            // date()関数を使用して、datetime-local形式の文字列に変換する
            $formattedDateTime = $dateTime->format('Y-m-d\TH:i');
            require_once(dirname(__DIR__) . "/template/edit.php");
            unset($_SESSION['isbnError']);
            unset($_SESSION['priceError']);
        }
    }
}
?>