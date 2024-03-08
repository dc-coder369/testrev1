<?php

class DatabaseOperation {
    private $servername;
    private $username;
    private $password;
    private $dbname;
    private $conn;

    public function __construct($servername, $username, $password, $dbname) {
        $this->servername = $servername;
        $this->username = $username;
        $this->password = $password;
        $this->dbname = $dbname;

        $this->connect();
    }

    private function connect() {
        $this->conn = new mysqli($this->servername, $this->username, $this->password, $this->dbname);

        if ($this->conn->connect_error) {
            die("Connection failed: " . $this->conn->connect_error);
        }
    }

    public function query($sql) {
        $result = $this->conn->query($sql);

        if (!$result) {
            die("Query failed: " . $this->conn->error);
        }

        return $result;
    }
    
    public function querydownload($sql, $params = []) {
        // Prepare the statement
        $stmt = $this->conn->prepare($sql);
    
        // Bind parameters if provided
        if ($params) {
            $types = str_repeat('s', count($params)); // Assuming all parameters are strings
            $stmt->bind_param($types, ...$params);
        }
    
        // Execute the statement
        $stmt->execute();
    
        // Get the result set
        $result = $stmt->get_result();
    
        if (!$result) {
            die("Query failed: " . $this->conn->error);
        }
    
        return $result;
    }
    public function select($table, $columns = "*", $conditions = array(), $conditionType = "AND", $recordType = 'multiple', $orderBy = null, $whereInConditions = array()) {
    $sql = "SELECT $columns FROM $table";

    // Handle regular WHERE conditions
    if (!empty($conditions)) {
        $sql .= " WHERE ";
        $conditionClauses = [];

        foreach ($conditions as $column => $value) {
            if(is_array($value))
            {
              $conditionClauses[] = "$column IN ('" . implode("', '", $value) . "')";
            }
            else
            {
                $conditionClauses[] = "$column = '$value'";
            }
           
        }

        $conditionsString = implode(" $conditionType ", $conditionClauses);
        $sql .= $conditionsString;
    }

    // Handle WHERE IN conditions
    if (!empty($whereInConditions)) {
        if (!empty($conditions)) {
            $sql .= " $conditionType ";
        } else {
            $sql .= " WHERE ";
        }

        $whereInClauses = [];

        foreach ($whereInConditions as $column => $values) {
            $whereInClauses[] = "$column IN ('" . implode("', '", $values) . "')";
        }

        $whereInConditionsString = implode(" $conditionType ", $whereInClauses);
        $sql .= $whereInConditionsString;
    }

    if ($orderBy) {
        $sql .= " ORDER BY $orderBy";
    } 

    // echo $sql;die; 

    $result = $this->query($sql);

    $data = [];
    if ($recordType == 'single') {
        $data = $this->fetchAssoc($result);
    } else {
        while ($row = $this->fetchAssoc($result)) {
            $data[] = $row;
        }
    }

    return $data;
}



 

    public function insert($table, $data) {
        $columns = implode(", ", array_keys($data));
        $values = "'" . implode("', '", array_values($data)) . "'";
        $sql = "INSERT INTO $table ($columns) VALUES ($values)";

        return $this->query($sql);
    }

     

    public function update($table, $data, $condition) {
        $set = "";
        foreach ($data as $column => $value) {
            $set .= "$column='$value', ";
        }
        $set = rtrim($set, ", ");
        $sql = "UPDATE $table SET $set";
        if (is_array($condition)) {
            $where = "";
            foreach ($condition as $column => $value) {
                $where .= "$column='$value' AND ";
            }
            $where = rtrim($where, " AND ");
    
            $sql .= " WHERE $where";
        } elseif (is_string($condition)) {
            // If $condition is a string, append it to the SQL statement
            $sql .= " WHERE $condition";
        } else {
            // Handle invalid condition type
            return false;
        }
        
    
        return $this->query($sql);
    }

    public function delete($table, $condition) {
        $sql = "DELETE FROM $table WHERE $condition";

        return $this->query($sql);
    }

    // Example of a simple inner join
    public function join($table1, $table2, $commonColumn) {
        $sql = "SELECT * FROM $table1 INNER JOIN $table2 ON $table1.$commonColumn = $table2.$commonColumn";

        $result = $this->query($sql);

        $data = [];
        while ($row = $this->fetchAssoc($result)) {
            $data[] = $row;
        }

        return $data;
    }

    public function fetchAssoc($result) {
        return $result->fetch_assoc();
    }

    public function closeConnection() {
        $this->conn->close();
    }

    
}
$database = new DatabaseOperation("localhost", "root", "", "testdbgmrcrev");
 
?>
