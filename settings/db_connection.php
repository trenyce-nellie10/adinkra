<?php
class DbConnection {
    private $host = "localhost";
    private $user = "root";
    private $pass = "";
    private $dbname = "shoppn";

    protected function connect() {
        $dsn = "mysql:host=" . $this->host . ";dbname=" . $this->dbname;
        try {
            $pdo = new PDO($dsn, $this->user, $this->pass);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $pdo;
        } catch (PDOException $e) {
            die("DB Connection Failed: " . $e->getMessage());
        }
    }
}
?>
