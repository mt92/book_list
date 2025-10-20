<?php
declare(strict_types=1);

/**
 * 引数の文字列が空文字の場合はfalse、空文字ではない場合はtrue
 * 
 * @param string $str 被判定文字列
 * @return boolean true: OK, false: 未入力
 */
function isNotNull(string $str): bool {
    return trim($str) !== '';
}

/* 半角英数字判定 */
function isHalfWidthAlnum($str): bool {
    return (bool) preg_match("/^[a-zA-Z0-9]+$/", $str);
}

/**
 * 数値判定
 * 
 * @param string $str 被判定文字列
 * @return boolean true: 数値, false: 数値ではない
 */
function isNumeric($str): bool {
    return is_numeric($str);
}

/**
 * 最大文字数判定
 * 
 * @param string $str 被判定文字列
 * @param integer $length 最大文字数
 * @return boolean true: 最大文字数未満, false: 最大文字数以上
 */
function isMaxLength(string $str, int $length): bool {
    $boolean = true;
    if(mb_strlen($str) > $length) {
        $boolean = false;
    }

    return $boolean;
}

// バリデーションチェック
function validateCheck($str, $type = null) {
    $errorMessage = '';

    if($type == "isnum") {
        if(!(isNumeric($str))) {
            $errorMessage = "半角数字で入力してください。";
        }
    } elseif($type == "id") {
        $errorMessage = userIdCheck($str);
    } elseif($type == "pass") {
        $errorMessage = userPassCheck($str);
    } elseif($type == "isbn") {
        $errorMessage = isbnCheck($str);
    } else {
        if(!(isNotNull($str))) {
            $errorMessage = "入力必須項目です。";
        }
    }

    return $errorMessage;
}

// ユーザーIDのバリデーションチェック
function userIdCheck(string $id) {
    if(!(isNotNull($id))) {
        return "入力必須項目です。";
    } elseif(!isHalfWidthAlnum($id)) {
        return "半角英数字で入力してください。";
    }

    return NULL;
}

// ユーザーパスワードのバリデーションチェック
function userPassCheck(string $pass) {
    if(!(isNotNull($pass))) {
        return "入力必須項目です。";
    } elseif(!isHalfWidthAlnum($pass)) {
        return "半角英数字で入力してください。";
    } elseif(!isMaxLength($pass, 16)) {
        return "文字数は16文字以内で入力してください。";
    }

    return NULL;
}

// ISBNのバリデーションチェック
function isbnCheck(string $isbn) {
    if(!isNumeric(str_replace('-', '', $isbn))) {
        return 'ISBNは半角数値で入力してください。ハイフンを入れる場合は半角の“-”で入力してください。';
    } elseif(!isMaxLength(str_replace('-', '', $isbn), 13)) {
        return '入力文字数オーバーしています。';
    }

    return NULL;
}

// ISBNのバリデーションチェック後のフォーマット
function isbnFormat(string $isbn): string {
    // 数字以外を除去
    $isbn = str_replace('-', '', $isbn);

    return preg_replace('/^(\d{3})(\d{1})(\d{6})(\d{2})(\d{1})$/', '$1-$2-$3-$4-$5', $isbn);
}
?>