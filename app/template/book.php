<?php declare(strict_types=1); ?>
<!DOCTYPE html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />  
        <title>書籍一覧</title>
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
            <div class="container">
                <h3 id="title">書籍一覧画面</h3>
                <a href="logout.php">ログアウト</a>
            </div>
            <div>
                <table border="1">
                    <thead>
                        <tr>
                            <th>タイトル</th>
                            <th>著者</th>
                            <th>出版社</th>
                            <td>
                                <form action="/htdocs/form.php" method="get">
                                    <button type="submit">登録</button>
                                </form>
                            </td>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($data as $row) { ?>
                            <tr>
                                <td><a href=<?php echo "/htdocs/book_detail.php?id=" . $row["id"] ?>><?php echo $row["title"]; ?></a></td>
                                <td><?php echo $row["author"]; ?></td>
                                <td><?php echo $row["publisher_name"]; ?></td>
                                <td class="function_button">
                                    <button style="width: 100%;" name="delete" onclick="deleteUser('<?php echo $row["id"]; ?>', '<?php echo $row["title"]; ?>');">削除</button>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
        <form action="book.php" name="delete_form" method="POST">
            <input type="hidden" name="id" value="" />
            <input type="hidden" name="delete" value="" />
        </form>
        <script>
            function deleteUser(id) {
                document.delete_form.id.value = id;
                document.delete_form.submit();
            }
        </script>
    </body>
</html>