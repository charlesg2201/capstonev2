<?php
require_once 'config.php';

class AccountRepository {
    private $connection;

    public function __construct() {
        $this->connection = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
        if ($this->connection->connect_error) {
            die("Connection failed: " . $this->connection->connect_error);
        }
    }
    
    public function createAccount($account_number, $username, $password, $account_type) {
        $stmt = $this->connection->prepare("INSERT INTO account_tbl (account_number, username, password, account_type) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("sssi", $account_number, $username, $password, $account_type);
        $stmt->execute();
        $stmt->close();
    }

    public function getAccountByUsername($username) {
        $stmt = $this->connection->prepare("SELECT * FROM account_tbl WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();
        return $result->fetch_assoc();
    }

    public function updateAccount($account_number, $username, $password, $account_type) {
        $stmt = $this->connection->prepare("UPDATE account_tbl SET account_number = ?, password = ?, account_type = ?, WHERE Username = ?");
        $stmt->bind_param("ssis", $password, $account_type, $account_number, $username);
        $stmt->execute();
        $stmt->close();
    }

    public function __destruct() {
        $this->connection->close();
    }
}
?>