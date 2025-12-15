<?php



require_once __DIR__ . '/db_credentials.php';

class Database {

    private $conn;
    public $error;

    public function __construct() {
        $this->conn = new mysqli(BD_HOST, BD_USER, BD_PASS, BD_NAME); 
        
        if ($this->conn->connect_error) {
            die("Error fatal de conexion: " . $this->conn->connect_error);
        }
        $this->conn->set_charset("utf8");

    }

    public function executeQuery($sql, $params = []) {
        $stmt  = $this->conn->prepare($sql);

        if ($params) {
            $types = str_repeat('s', count($params));
            $stmt->bind_param($types, ...$params);
        }

        $stmt->execute();
        $result  = $stmt->get_result();
        $data = $result->fetch_all(MYSQLI_ASSOC);
        $stmt->close();
        return $data;

    }

    public function executeUpdate($sql, $params = []) {
        $stmt  = $this->conn->prepare($sql);

        if ($params) {
            $types = str_repeat('s', count($params));
            $stmt->bind_param($types, ...$params);
        }
        $success = $stmt->execute();

        if (!$success) {
            $this->error = $stmt->error;
            return false;
        }

        $filas = $stmt->affected_rows;
        $stmt->close();
        return $filas;

    }

    public function close(){
        $this->conn->close();
    }


}



?>