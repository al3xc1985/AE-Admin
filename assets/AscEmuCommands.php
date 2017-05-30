<?php
require_once('PHPTelnet.php');
require_once('MySQLConnection.php');

class AECommands
{
    public $accountCache = '';
    public $updateTime = '';
    
    private function connect()
    {
        $configs = include('config.php');
        
        $t = new Telnet($configs['telnet_host'], $configs['telnet_port']);
        $t->login($configs['telnet_user'], $configs['telnet_pass']);
        $t->exec('webclient');
        return $t;
    }
    public function runInfoCommand()
    {
        $t = $this->connect();
        
        $buffer = $t->exec('info');
        $t->setPrompt($buffer);
        
        $MySQLConnection = new MySQLConnection();
        $query = "INSERT INTO basic_information VALUES(".time().", ".$buffer.")";
        $MySQLConnection->runQuery($query);
        
        return "Command 'info' performed successfully received '".$buffer;
    }
    
    public function runReloadScripts()
    {
        $t = $this->connect();
        
        $buffer = $t->exec('reloadscripts');
        $t->setPrompt($buffer);
        
        return "Command 'reloadscripts' performed successfully ".$buffer;
    }
    
    public function runGetAccountData()
    {
        $t = $this->connect();
        
        $buffer = $t->exec('getaccountdata');
        $t->setPrompt($buffer);
        
        $this->accountCache = $buffer;
        $this->updateTime = date("Y-m-d H:i:s");
        
        return "Command 'getaccountdata' performed successfully";
    }
}
?>