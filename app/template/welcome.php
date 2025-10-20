<?php declare(strict_types=1); ?>
<!DOCTYPE html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />  
        <title>書籍管理 ログイン</title>
        <link rel="stylesheet" href="./css/common.css">
        <link rel="stylesheet" href="./css/style.css">
        <script src="./js/book.js" defer></script>
    </head>
    <body>
        <div id="header">
            <h1>
                <div class="clearfix">
                    <div class="fl">書籍管理システム</div>
                </div>
            </h1>
        </div>
        <div id="main">
            <div class="container -login">
                <div class="login-box">
                    <div class="login-box__inner">
                        <ul class="login-box__menu">
                            <li class="login-box__menuItem">
                                <a class="login-box__menuLink<?php if($disabledFlag == "login") echo ' -disabled'; ?>" href=<?php echo "/htdocs/welcome.php?id=login"; ?>>ログイン</a>
                            </li>
                            <li class="login-box__menuItem">
                                <a class="login-box__menuLink<?php if($disabledFlag == "new") echo ' -disabled'; ?>" href=<?php echo "/htdocs/welcome.php?id=new"; ?>>登録</a>
                            </li>
                        </ul>
<?php if($disabledFlag == "new") : ?>
                        <h3 id="title">新規ユーザー登録</h3>
                        <form name="add_user" id="registerForm" method="POST">
                            <div class="login-box__form">
                                <div class="login-box__formItem">
                                    <p class="login-box__formLabel">ユーザーID:</p>
                                    <input type="text" name="id" value="<?= htmlspecialchars($loginId ?? '') ?>">
                                    <?php if($idError) : ?><p class="error"><?php echo $idError; ?></p><?php endif; ?>
                                </div>
                                <div class="login-box__formItem">
                                    <p class="login-box__formLabel">パスワード:</p>
                                    <input type="password" name="password" maxlength="16" placeholder="最大16文字のパスワードを入力">
                                    <?php if($passError) : ?><p class="error"><?php echo $passError; ?></p><?php endif; ?>
                                </div>
                                <div class="login-box__formItem">
                                    <p class="login-box__formLabel">氏名:</p>
                                    <input type="text" name="name" value="<?= htmlspecialchars($name ?? '') ?>">
                                    <?php if($nameError) : ?><p class="error"><?php echo $nameError; ?></p><?php endif; ?>
                                </div>
                                <div class="login-box__formBtn">
                                    <input type="hidden" name="form_type" value="register">
                                    <input type="hidden" name="confirmed" id="confirmed" value="0">
                                    <button type="submit">登録</button>
                                </div>
                            </div>
                        </form>
    <?php if ($showConfirm): // バリデーション成功時 ?>
                        <script>
                            if (confirm("この内容で登録しますか？")) {
                                // confirmedフラグを立てて再送信
                                document.getElementById('confirmed').value = "1";
                                document.getElementById('registerForm').submit();
                            }
                        </script>
    <?php endif; ?>
<?php else : ?>
                        <h3 id="title">ログイン</h3>
                        <form action="welcome.php" method="POST">
                            <div class="login-box__form">
                                <div class="login-box__formItem">
                                    <p class="login-box__formLabel">ユーザーID:</p>
                                    <input type="text" name="id" value="<?= htmlspecialchars($loginId ?? '') ?>">
                                    <?php if($idError) : ?><p class="error"><?php echo $idError; ?></p><?php endif; ?>
                                </div>
                                <div class="login-box__formItem">
                                    <p class="login-box__formLabel">パスワード:</p>
                                    <input type="password" name="password" maxlength="16">
                                    <?php if($passError) : ?><p class="error"><?php echo $passError; ?></p><?php endif; ?>
                                </div>
                                <div class="login-box__formBtn">
                                    <input type="hidden" name="form_type" value="login">
                                    <button type="submit">ログイン</button>
                                </div>
                            </div>
                        </form>
<?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>