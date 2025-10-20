<?php 
declare(strict_types=1);
require_once(dirname(__DIR__) . "/library/common.php");

// ログイン済みならリダイレクト
if (isset($_SESSION['loginId'])) {
    header('Location: /htdocs/book.php');
    exit;
}

$idError = Session::get("idError");
$passError = Session::get("passError");
$nameError = Session::get("nameError");
$showConfirm = false;

$disabledFlag = "login";
if((isset($_GET['id']) && $_GET['id'] == "new") || isset($_POST['add_user'])) {
    $disabledFlag = "new";
}

// form送信後の処理
if(mb_strtolower($_SERVER['REQUEST_METHOD']) === 'post') {
    if ($_POST['form_type'] === 'login') {
        // ログイン処理
        $loginId = $_POST['id'];
        $password = $_POST['password'];
        if(Auth::login($loginId, $password)) {
            header('Location: /htdocs/book.php');
        } else {
            // バリデーションエラー表示
            $idError = validateCheck($loginId, "id");
            $passError = validateCheck($password, "pass");
            $account = Auth::getAccountById($loginId);

            if(!empty($account["login_id"])) { // IDの照合
                if($account["login_id"] != $loginId) {
                    $idError = "入力したIDは登録されていません。";
                    Session::set("idError", $idError);
                }
                if(!$passError) {
                    // IDに紐づくデータのパスワードと引数のパスワードが一致するか確認
                    $result = password_verify($password, $account["password"]);
                    if($result === false) {
                        $passError = "パスワードが一致しません。";
                        Session::set("passError", $passError);
                    }
                } else {
                    Session::set("passError", $passError);
                }
            } else {
                $idError = "入力したIDは登録されていません。";
                Session::set("idError", $idError);
                if($passError) {
                    Session::set("passError", $passError);
                }
            }

            require_once(dirname(__DIR__) . "/template/welcome.php");
            
            unset($_SESSION['idError']);
            unset($_SESSION['passError']);
        }
    } else {
        // 新規登録（バリデーションチェック）
        $loginId = $_POST['id'];
        $idError = validateCheck($loginId, "id");
        if(!$idError) { // IDの重複チェック
            $account = Auth::getAccountById($loginId);
            if($account && $account["login_id"] == $loginId) {
                $idError = "入力したIDは既に登録されています。";
            }
        }
        $password = $_POST['password'];
        $passError = validateCheck($password, "pass");
        $name = $_POST['name'];
        $nameError = validateCheck($name);

        if(!$idError && !$passError && !$nameError) {
            $showConfirm = true; // エラーがなければ JSで確認ダイアログを出す
            require_once(dirname(__DIR__) . "/template/welcome.php");
        } else {
            if($idError) {
                Session::set("idError", $idError);
            }
            if($passError) {
                Session::set("passError", $passError);
            }
            if($nameError) {
                Session::set("nameError", $nameError);
            }
            require_once(dirname(__DIR__) . "/template/welcome.php");
            unset($_SESSION['idError']);
            unset($_SESSION['passError']);
            unset($_SESSION['nameError']);
        }
    }
} else {
    require_once(dirname(__DIR__) . "/template/welcome.php");
}

// 新規登録（バリデーションチェック後の登録処理）
if (isset($_POST['confirmed']) && $_POST['confirmed'] === '1') {
    $loginId = $_POST['id'];
    $password = $_POST['password'];
    $name = $_POST['name'];
    // DateTimeオブジェクトを作成し、現在の日時を取得
    date_default_timezone_set('Asia/Tokyo');
    $dateTime = new DateTime();
    // date()関数を使用して、datetime-local形式の文字列に変換する
    $created = $dateTime->format('Y-m-d\TH:i');
    
    $success = Users::insert($loginId, $password, $name, $created);

    if ($success) {
        $id = DatabaseAccess::lastInsertId(); // 最後に追加されたIDを取得
        writeLog("【処理】ID:${id} 「${name}」をユーザー登録");

        // JavaScriptで完了ダイアログを表示し、その後リダイレクト
        echo <<<HTML
        <script>
            alert("ユーザー登録が完了しました。");
            window.location.href = "/htdocs/welcome.php";
        </script>
        HTML;
        exit; // これ以上出力しないように終了  
    } else {
        echo <<<HTML
        <script>
            alert("登録に失敗しました。");
        </script>
        HTML;
        exit;
    }
}
?>