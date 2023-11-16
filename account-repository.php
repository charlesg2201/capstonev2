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

    public function createAccount($username, $password, $userType, $isActive) {
        $stmt = $this->connection->prepare("INSERT INTO Account (Username, Password, UserType, IsActive) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("sssi", $username, $password, $userType, $isActive);
        $stmt->execute();
        $stmt->close();
    }

    public function getAccountByUsername($username) {
        $stmt = $this->connection->prepare("SELECT * FROM Account WHERE Username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();
        return $result->fetch_assoc();
    }

    public function updateAccount($username, $password, $userType, $isActive) {
        $stmt = $this->connection->prepare("UPDATE Account SET Password = ?, UserType = ?, IsActive = ? WHERE Username = ?");
        $stmt->bind_param("ssis", $password, $userType, $isActive, $username);
        $stmt->execute();
        $stmt->close();
    }

    public function __destruct() {
        $this->connection->close();
    }
}
?>