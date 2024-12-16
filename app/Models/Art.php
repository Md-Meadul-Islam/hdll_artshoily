<?php
namespace App\Models;

use App\Config\Database;

class Art
{
    private $arts = 'arts';
    private $users = 'users';
    protected $connection;
    public function __construct()
    {
        $this->connection = Database::getInstance()->getConnection();
    }
    public function arts($page = 1)
    {
        $limit = 20;
        $offset = ($page - 1) * 1;
        $data = [];

        $stmt = $this->connection->prepare("SELECT 
            a.*,
            JSON_ARRAYAGG(JSON_OBJECT('user_id', u.user_id, 'first_name', u.first_name, 'last_name', u.last_name)) AS users
        FROM {$this->arts} AS a
        LEFT JOIN {$this->users} AS u 
        ON JSON_CONTAINS(a.user_ids, JSON_QUOTE(u.user_id), '$')
        GROUP BY a.id
        ORDER BY a.id DESC 
        LIMIT ? OFFSET ?
    ");
        $stmt->bind_param('ii', $limit, $offset);

        $stmt->execute();
        $result = $stmt->get_result();
        while ($row = $result->fetch_assoc()) {
            $row['users'] = json_decode($row['users'], true);  // Decode users JSON array
            $data[] = $row;
        }
        return $data;
    }
    public function view($a)
    {
        $stmt = $this->connection->prepare("SELECT 
            a.*,
            JSON_ARRAYAGG(JSON_OBJECT('user_id', u.user_id, 'first_name', u.first_name, 'last_name', u.last_name)) AS users
            FROM {$this->arts} AS a
            LEFT JOIN {$this->users} AS u 
            ON JSON_CONTAINS(a.user_ids, JSON_QUOTE(u.user_id), '$')
            WHERE a.art_id = ?
            GROUP BY a.id
            ORDER BY a.id DESC 
        ");
        $stmt->bind_param('s', $a);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        $row['users'] = json_decode($row['users'], true);  // Decode users JSON array
        return $row;
    }
}