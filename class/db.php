<?php
define('ROOT', dirname(__DIR__) . '/');
if (!file_exists(ROOT . 'config.php')) {
    die('File config.php tidak ditemukan di: ' . ROOT . 'config.php'); } // ngambek kalo ga gini 
require_once ROOT . 'config.php';
define('GAMBAR', ROOT . 'gambar/');
define('BASE_URL', 'http://localhost/project/');  // ganti sesuai folder , jangn lupain di .htaccess juga
 
 
class Database {
    protected $host;
    protected $user;
    protected $password;
    protected $db_name;
    public $conn;

    public function __construct() {
        $this->getConfig();
        $this->conn = new mysqli($this->host, $this->user, $this->password, $this->db_name);
        if ($this->conn->connect_error) {
            die("Connection failed: " . $this->conn->connect_error);
        }
    }

    private function getConfig() {
        include ROOT . 'config.php';
        $this->host = $config['host'];
        $this->user = $config['username'];
        $this->password = $config['password'];
        $this->db_name = $config['db_name'];
    }

    public function query($sql, $params = []) {
        if (empty($params)) {
            return $this->conn->query($sql);
        } else {
            $stmt = $this->conn->prepare($sql);
            if ($stmt === false) {
                error_log("Failed to prepare statement: " . $this->conn->error);
                return false;
            }

            // Dynamically determine types for bind_param
            $types = '';
            foreach ($params as $param) {
                if (is_int($param)) {
                    $types .= 'i';
                } elseif (is_float($param)) {
                    $types .= 'd';
                } else {
                    $types .= 's'; // Default to string
                }
            }
            $stmt->bind_param($types, ...$params);

            if ($stmt->execute()) {
                // For SELECT, return the result set
                if (strtoupper(substr(trim($sql), 0, 6)) == 'SELECT') {
                    $result = $stmt->get_result();
                    $stmt->close();
                    return $result;
                }
                // For INSERT, UPDATE, DELETE, return true on success
                $stmt->close();
                return true;
            } else {
                error_log("Failed to execute statement: " . $stmt->error);
                $stmt->close();
                return false;
            }
        }
    }

    public function get($table, $where = null) {
        if ($where) $where = " WHERE " . $where;
        $sql = "SELECT * FROM " . $table . $where;
        $result = $this->query($sql);
        return $result->fetch_assoc(); 
    }

    public function getAll($table, $where = null) {
        if ($where) $where = " WHERE " . $where;

        $sql = "SELECT * FROM " . $table . $where;
        $sql_count = "SELECT COUNT(*) FROM " . $table . $where;
        if(isset($sql_where)) {
            $sql .= " " . $sql_where;
            $sql_count .= " " . $sql_where;
        }
        $result_count = $this->query($sql_count);
        $count=0;
        if($result_count){
            $row_count = $result_count->fetch_row();
            $count = $row_count[0];
        }
        $per_page = 10;
        $num_page = ceil($count / $per_page);
        $limit = $per_page;

        if (isset($_GET['page'])) {
            $page = (int)$_GET['page'];
            $start = ($page - 1) * $per_page;
        } else {
            $start = 0;
        }
        $sql .= " LIMIT " . $start . "," . $limit;
        $result = $this->query($sql);
        return [
            'data' => $result,
            'num_page' => $num_page
        ];
    }

    public function insert($table, $data)
    {
        if (is_array($data)) {
            foreach ($data as $key => $val) {
                $column[] = $key;
                $value[] = "'{$val}'";
            }
            $columns = implode(",", $column);
            $values = implode(",", $value);
        }
        $sql = "INSERT INTO " . $table . " (" . $columns . ") VALUES (" . $values . ")";
        $sql = $this->query($sql);
        if ($sql == true) {
            return $sql;
        } else {
            return false;
        }
    }
    public function update($table, $data, $where)
    {
        $update_value = [];
        if (is_array($data)) {
            foreach ($data as $key => $val) {
                $update_value[] = "$key='{$val}'";
            }
            $update_value = implode("," ,$update_value);
        }
        $sql = "UPDATE " . $table . " SET " . $update_value . " WHERE " . $where;
        $sql = $this->query($sql);
        if ($sql == true) {
            return true;
        } else {
            return false;
        }
    }
    public function delete($table, $filter)
    {
        $sql = "DELETE FROM " . $table . " " . $filter;
        $sql = $this->query($sql);
        if ($sql == true) {
            return true;
        } else {
            return false;
        }
    }
    // dari yang sebelumnya di home.php 
    public function renderPagination($num_page, $current_page, $query_param = '') {
        echo "<ul class='pagination'>";

        $query_string = !empty($query_param) ? "&q=" . urlencode($query_param) : "";

        // Previous button
        if ($current_page > 1) {
            $prev = $current_page - 1;
            $prev_link = "?page={$prev}" . $query_string;
            echo "<li><a href='{$prev_link}'>&laquo; </a></li>";
        } else {
            echo "<li class='disabled'><a>&laquo; </a></li>";
        }

        // Page numbers
        for ($i = 1; $i <= $num_page; $i++) {
            $link = "?page={$i}" . $query_string;
            $class = ($current_page == $i ? 'active' : '');
            echo "<li><a class=\"{$class}\" href=\"{$link}\">{$i}</a></li>";
        }

        // Next button
        if ($current_page < $num_page) {
            $next = $current_page + 1;
            $next_link = "?page={$next}" . $query_string;
            echo "<li><a href='{$next_link}'> &raquo;</a></li>";
        } else {
            echo "<li class='disabled'><a> &raquo;</a></li>";
        }
        echo "</ul>";
    }
}
?>