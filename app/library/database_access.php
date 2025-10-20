<?php
declare(strict_types=1);

// 書籍情報テーブルへのアクセス
class DatabaseAccess {

    private static PDO $pdo;

    private function __construct() {}

    public static function getInstance(): PDO {
        if(!isset(self::$pdo)) {
            $dsn = "pgsql:host=book_list_php_db_container;dbname=postgres";
            self::$pdo = new PDO($dsn, "root", "root");
        }
        return self::$pdo;
    }

    public static function fetchAll(): array {
        $sql = "SELECT * FROM books ORDER BY id";
        $stmt = self::getInstance()->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function fetchBy(string $id) {
        $sql = "SELECT * FROM books WHERE id = :id ORDER BY id";
        $stmt = self::getInstance()->prepare($sql);
        $param['id'] = $id; // SQLの :id にバインドするための値（引数 $id）をセット
        $stmt->execute($param); // $param 配列の中の ['id' => $id] が :id にバインド
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function deleteBy(string $id) {
        $sql = "DELETE FROM books WHERE id = :id";
        $stmt = self::getInstance()->prepare($sql);
        $param = ["id" => $id];
        return $stmt->execute($param);
    }

    public static function insert(string $title, string $isbn, int $price, string $author, string $publisher_name, string $created) {
        $sql = "INSERT INTO books (title, isbn, price, author, publisher_name, created) VALUES (:title, :isbn, :price, :author, :publisher_name, :created);";
        $param = [
            "title" => $title,
            "isbn" => $isbn,
            "price" => $price,
            "author" => $author,
            "publisher_name" => $publisher_name,
            "created" => $created
        ];
        $stmt = self::getInstance()->prepare($sql);
        return $stmt->execute($param);
    }
    
    public static function lastInsertId() {
        return self::getInstance()->lastInsertId();
    }

    public static function update(string $id, string $title, string $isbn, int $price, string $author, string $publisher_name, string $created) {
        $sql = "UPDATE books SET title=:title, isbn=:isbn, price=:price, author=:author, publisher_name=:publisher_name, created=:created WHERE id = :id;";
        $param = [
            "id" => $id,
            "title" => $title,
            "isbn" => $isbn,
            "price" => $price,
            "author" => $author,
            "publisher_name" => $publisher_name,
            "created" => $created
        ];
        $stmt = self::getInstance()->prepare($sql);
        return $stmt->execute($param);
    }
}

// ユーザー情報テーブルへのアクセス
class Users {
    private static ?PDO $pdo = null;

    private static function init(): PDO {
        if (self::$pdo === null) {
            self::$pdo = DatabaseAccess::getInstance();
        }
        return self::$pdo;
    }

    public static function getById(string $id): array|false {
        $sql = "SELECT * FROM users WHERE login_id = :login_id";
        $stmt = self::init()->prepare($sql);
        $param = ["login_id" => $id];
        $stmt->execute($param);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function insert(string $id, string $password, string $name, string $created) {
        $sql = "INSERT INTO users (login_id, password, name, created) VALUES (:login_id, :password, :name, :created);";
        $param = [
            "login_id" => $id,
            "password" => password_hash($password, PASSWORD_DEFAULT),
            "name" => $name,
            "created" => $created
        ];
        $stmt = self::init()->prepare($sql);
        return $stmt->execute($param);
    }
}