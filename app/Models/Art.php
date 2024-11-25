<?php
namespace App\Models;

use App\Config\Database;

class Art
{
    private $arts = 'arts';
    protected $connection;
    public function __construct()
    {
        $this->connection = Database::getInstance()->getConnection();
    }
    public function view($a)
    {
        $stmt = $this->connection->prepare("SELECT *
            FROM {$this->arts}
            WHERE art_id = ?
        ");
        $stmt->bind_param('s', $a);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        return $row;
    }
}