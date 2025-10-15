<?php
declare(strict_types=1);
if (session_status() == PHP_SESSION_NONE) {
   session_start();
}
// 共通部分の読込
define('BASE_PATH', dirname(__DIR__));
require_once(BASE_PATH . "/library/database_access.php"); // DB関連
require_once(BASE_PATH . "/library/logger.php"); // ログ書き込み
require_once(BASE_PATH . "/library/validate.php"); // 入力バリデーション
?>