<?php
class MySQLConnection
{   
    public function connect()
    {
        $configs = include('config.php');
        
        $mysqli = new mysqli($configs['db_host'], $configs['db_user'], $configs['db_pass'], $configs['db_name']);
        if(!$mysqli)
        {
            die("Connection failed: " . $mysqli->error);
        }
        
        return $mysqli;
    }
    
    public function getResult($query)
    {
        $mysqli = $this->connect();

        $result = $mysqli->query($query);

        $row = $result->fetch_array(MYSQLI_ASSOC);

        $result->close();

        $mysqli->close();
        
        return $row;
    }
    
    public function runQuery($query)
    {
        $mysqli = $this->connect();
        
        mysqli_query($mysqli, $query) or die(mysqli_error($mysqli));
    }
}
?>