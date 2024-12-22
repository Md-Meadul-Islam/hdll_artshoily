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
    public function arts($page = 1, $limit = 20)
    {
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
    public function storeArt($data)
    {
        $stmt = $this->connection->prepare("INSERT INTO {$this->arts} (art_id, user_ids, name, date_created, place_created, media, canvas_type, size, frame, description, price, currency, image, imgalt, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        if ($stmt === false) {
            die('Prepare failed: ' . htmlspecialchars($this->connection->error));
        }
        $stmt->bind_param('sssssssssssssss', $data['art_id'], $data['artists'], $data['name'], $data['creationDate'], $data['place'], $data['media'], $data['canvasType'], $data['size'], $data['frame'], $data['description'], $data['price'], $data['currency'], $data['image'], $data['name'], $data['availability']);
        if ($stmt->execute()) {
            $insertId = $this->connection->insert_id;
            $fetchStmt = $this->connection->prepare("SELECT  a.art_id, a.name, a.image, a.price, a.currency, a.cr_at,
                JSON_ARRAYAGG(JSON_OBJECT('user_id', u.user_id, 'first_name', u.first_name, 'last_name', u.last_name)) AS users
                FROM {$this->arts} AS a
                LEFT JOIN {$this->users} AS u 
                ON JSON_CONTAINS(a.user_ids, JSON_QUOTE(u.user_id), '$')
                WHERE a.id = ?
                GROUP BY a.id
                ");
            if ($fetchStmt === false) {
                die('Prepare failed: ' . htmlspecialchars($this->connection->error));
            }
            $fetchStmt->bind_param('i', $insertId);
            $fetchStmt->execute();
            $result = $fetchStmt->get_result();
            $insertedRow = $result->fetch_assoc();
            return ['data' => $insertedRow];
        } else {
            return ['error' => $stmt->error];
        }
    }
    public function moreFromArtist($art_id, $user_id, $limit = 5)
    {
        $data = [];
        $stmt = $this->connection->prepare("SELECT 
            a.*
            FROM {$this->arts} AS a
            WHERE JSON_CONTAINS(a.user_ids, JSON_QUOTE(?), '$')
            AND a.art_id != ?
            ORDER BY a.id DESC 
            LIMIT ?
        ");
        $stmt->bind_param('ssi', $user_id, $art_id, $limit);
        $stmt->execute();
        $result = $stmt->get_result();
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
        return $data;
    }
    public function limitedEdition()
    {
        $limit = 3;
        $data = [];

        $stmt = $this->connection->prepare("SELECT 
            a.*,
            JSON_ARRAYAGG(JSON_OBJECT('user_id', u.user_id, 'first_name', u.first_name, 'last_name', u.last_name)) AS users
        FROM {$this->arts} AS a
        LEFT JOIN {$this->users} AS u 
        ON JSON_CONTAINS(a.user_ids, JSON_QUOTE(u.user_id), '$')
        GROUP BY a.art_id
        ORDER BY a.art_id DESC 
        LIMIT ?
    ");
        $stmt->bind_param('i', $limit);

        $stmt->execute();
        $result = $stmt->get_result();
        while ($row = $result->fetch_assoc()) {
            $row['users'] = json_decode($row['users'], true);  // Decode users JSON array
            $data[] = $row;
        }
        return $data;
    }
}