<?php
class Database {
    private $host = "localhost";
    private $username = "root";
    private $password = "";
    private $database = "u620982390_dbresihive";
    private $connection;

    private $query; // Store the query as a class property

    public function __construct() {
        $this->connection = new mysqli($this->host, $this->username, $this->password, $this->database);

        if ($this->connection->connect_error) {
            die("Connection failed: " . $this->connection->connect_error);
        }
    }

    // Public method to get the connection
    public function getConnection() {
        return $this->connection;
    }

    public function setQuery($query) {
        // Implement your query setting logic here
        $this->query = $query;
        // ... (rest of the logic)
    }

    public function executeQuery() {
        // Implement your query execution logic here
        if (empty($this->query)) {
            die("Error: Empty query");
        }

        $result = $this->connection->query($this->query);

        if (!$result) {
            die("Error executing query: " . $this->connection->error);
        }

        // Reset the query property after execution
        $this->query = '';

        return $result;
    }

    public function closeConnection() {
        $this->connection->close();
    }
}

// Example usage:
$mydb = new Database();
?>
