<?php
declare(strict_types=1);
// 共通部分の読込
define('BASE_PATH', dirname(__DIR__));
require_once(BASE_PATH . "/library/database_access.php"); // DB関連
require_once(BASE_PATH . "/library/session.php"); // セッション処理
require_once(BASE_PATH . "/library/auth.php"); // セッション処理

// ログインされてなければ移動させる
if (session_status() == PHP_SESSION_NONE) {
   Session::start();
}
$currentPage = basename($_SERVER['PHP_SELF']); // 現在のページを取得
if ($currentPage !== 'welcome.php' && !Auth::isLoggedIn()) {
   header("Location: /htdocs/welcome.php");
   exit();
}

require_once(BASE_PATH . "/library/logger.php"); // ログ書き込み
require_once(BASE_PATH . "/library/validate.php"); // 入力バリデーション
?>