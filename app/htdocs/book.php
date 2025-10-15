<?php
declare(strict_types=1);
require_once(dirname(__DIR__) . "/library/common.php");

if(mb_strtolower($_SERVER['REQUEST_METHOD']) === 'post') {
    if (isset($_POST['delete'])) {
        $id = $_POST['id'] ?? '';
        $title = $_POST['title'] ?? '';
        if (!empty($id)) {
            $success = DatabaseAccess::deleteBy($id);

            // javascript側に成功/失敗を伝える
            if ($success) {
                http_response_code(200); // 成功
                writeLog("【処理】ID:${id} 「${title}」削除");
            } else {
                http_response_code(500); // 削除失敗
            }
            exit;
        }
    }
}

$data = DatabaseAccess::fetchAll();
if (!isset($_SESSION['loginFlag'])) {
    writeLog("【表示】一覧画面");
}
require_once(dirname(__DIR__) . "/template/book.php");
?>