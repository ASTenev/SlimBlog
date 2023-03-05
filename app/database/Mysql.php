<?php
namespace App\Database;
use App\Interfaces\RepositoryInterface;

use PDO;

class Mysql implements RepositoryInterface{
    private $conn;

    function __construct() {
        // Create connection
        $db_config=include_once __DIR__ . "/../config/database.php";
        $dsn = "mysql:host={$db_config['host']};dbname={$db_config['name']};charset=utf8mb4";
        $options = array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION);
        $this->conn = new PDO($dsn, $db_config['username'], $db_config['password'], $options);
    }

    function __destruct() {
        // Close connection
        $this->conn = null;
    }

    function create(string $table, array $data) {
        // Generate SQL query
        $keys = implode(", ", array_keys($data));
        $values = ":" . implode(", :", array_keys($data));
        $sql = "INSERT INTO $table ($keys) VALUES ($values)";

        // Prepare and execute statement
        $stmt = $this->conn->prepare($sql);
        foreach ($data as $key => &$value) {
            $stmt->bindParam(":$key", $value);
        }
        $stmt->execute();
        return $stmt->rowCount() > 0;
    }

    function read(string $table, string $condition_field = '', string $condition_value = '') {
        // Generate SQL query
        if($condition_field&&$condition_value)
        {
            $where = "WHERE `$condition_value` = `$condition_value`";
        }
        else
        {
            $teaser = ', LEFT(content, 120) AS content';
            $where = '';
        }
        $sql = "SELECT * $teaser FROM $table $where";

        // Prepare and execute statement
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result !== false ? $result : false;
    }

    function update(string $table, int $id, array $data) {

        if(!$id) return false; // Prevent updating all records (without condition)
        // Generate SQL query
        $set = array();
        foreach ($data as $key => $value) {
            $set[] = "$key = :$key";
        }
        $sql = "UPDATE $table SET " . implode(", ", $set) . "WHERE id = $id";

        // Prepare and execute statement
        $stmt = $this->conn->prepare($sql);
        foreach ($data as $key => &$value) {
            $stmt->bindParam(":$key", $value);
        }
        $stmt->execute();
        return $stmt->rowCount() > 0;
    }

    function delete(string $table, int $id) {
        // Generate SQL query
        if(!$id) return false; // Prevent deleting all records (without condition
        $sql = "DELETE FROM $table WHERE id = $id";

        // Prepare and execute statement
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->rowCount() > 0;
    }
}
