<?php
declare(strict_types=1);
require_once(dirname(__DIR__) . "/library/database_access.php");

if(mb_strtolower($_SERVER['REQUEST_METHOD']) === 'post') {
    if (isset($_POST['delete'])) {
        $id = $_POST['id'] ?? '';
        if (!empty($id)) {
            $success = DatabaseAccess::deleteBy($id);

            // javascript側に成功/失敗を伝える
            if ($success) {
                http_response_code(200); // 成功
            } else {
                http_response_code(500); // 削除失敗
            }
            exit;
        }
    }
}

$data = DatabaseAccess::fetchAll();
require_once(dirname(__DIR__) . "/template/book.php");
?>