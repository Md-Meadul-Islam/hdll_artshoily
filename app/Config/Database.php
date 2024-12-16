<?php
namespace App\Config;

use Exception;
use mysqli;

class Database extends Singleton
{
    private $serverName = 'localhost';
    private $dbName = 'artshoily';//u664133865_artshoily';
    private $userName = 'root';//u664133865_art';
    private $password = '';//m^~Q?I5[D';
    protected $connection;
    protected function __construct()
    {
        $this->connection = null;
        try {
            $this->connection = new mysqli($this->serverName, $this->userName, $this->password, $this->dbName);
            if ($this->connection->connect_error) {
                throw new Exception("Error Processing Request" . $this->connection->connect_error, 1);

            }
        } catch (Exception $e) {
            echo "Connection Error" . $e->getMessage();
        }
    }
    public function getConnection()
    {
        return $this->connection;
    }
}