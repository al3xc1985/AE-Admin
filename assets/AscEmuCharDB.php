<?php
require_once('MySQLConnection.php');

class AECharDatabase
{
    public function connect()
    {
        $configs = include('config.php');
        
        $mysqli = new mysqli($configs['char_db_host'], $configs['char_db_user'], $configs['char_db_pass'], $configs['char_db_name']);
        if(!$mysqli)
        {
            die("Connection failed: " . $mysqli->error);
        }
        
        return $mysqli;
    }
    
    public function getAllCharacters()
    {
        $mysqli = $this->connect();

        $result = $mysqli->query("SELECT * FROM characters");
        
        while($row = $result->fetch_row())
        {
          $rows[]=$row;
        }

        $row = $result->fetch_array(MYSQLI_ASSOC);

        $result->close();

        $mysqli->close();
        
        return $rows;
    }
}