<?php
namespace App\Models;

use App\Config\Database;

class Sculpture
{
    private $sculpture = 'sculptures';
    private $users = 'users';
    protected $connection;
    public function __construct()
    {
        $this->connection = Database::getInstance()->getConnection();
    }
    public function sculptures($page = 1, $limit = 20)
    {
        $offset = ($page - 1) * $limit;
        $data = [];

        $stmt = $this->connection->prepare("SELECT 
            s.*,
            JSON_ARRAYAGG(JSON_OBJECT('user_id', u.user_id, 'first_name', u.first_name, 'last_name', u.last_name)) AS users
        FROM {$this->sculpture} AS s
        LEFT JOIN {$this->users} AS u 
        ON JSON_CONTAINS(s.user_ids, JSON_QUOTE(u.user_id), '$')
        GROUP BY s.id
        ORDER BY s.id DESC 
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
    public function view($sid)
    {
        $stmt = $this->connection->prepare("SELECT 
            s.*,
            JSON_ARRAYAGG(JSON_OBJECT('user_id', u.user_id, 'first_name', u.first_name, 'last_name', u.last_name)) AS users
            FROM {$this->sculpture} AS s
            LEFT JOIN {$this->users} AS u 
            ON JSON_CONTAINS(s.user_ids, JSON_QUOTE(u.user_id), '$')
            WHERE s.sculpture_id = ?
            GROUP BY s.id
        ");
        $stmt->bind_param('s', $sid);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        $row['users'] = json_decode($row['users'], true);  // Decode users JSON array
        return $row;
    }
    public function store($data)
    {
        $stmt = $this->connection->prepare("INSERT INTO {$this->sculpture} (sculpture_id, user_ids, name, date_created, place_created, media, canvas_type, size, frame, description, price, currency, image, imgalt, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        if ($stmt === false) {
            die('Prepare failed: ' . htmlspecialchars($this->connection->error));
        }
        $stmt->bind_param('sssssssssssssss', $data['sculpture_id'], $data['artists'], $data['name'], $data['creationDate'], $data['place'], $data['media'], $data['canvasType'], $data['size'], $data['frame'], $data['description'], $data['price'], $data['currency'], $data['image'], $data['name'], $data['availability']);
        if ($stmt->execute()) {
            $insertId = $this->connection->insert_id;
            $fetchStmt = $this->connection->prepare("SELECT  s.sculpture_id, s.name, s.image, s.price, s.currency, s.cr_at,
                JSON_ARRAYAGG(JSON_OBJECT('user_id', u.user_id, 'first_name', u.first_name, 'last_name', u.last_name)) AS users
                FROM {$this->sculpture} AS s
                LEFT JOIN {$this->users} AS u 
                ON JSON_CONTAINS(s.user_ids, JSON_QUOTE(u.user_id), '$')
                WHERE s.id = ?
                GROUP BY s.id
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
    public function update($data)
    {
        $stmt = $this->connection->prepare("UPDATE {$this->sculpture} 
            SET user_ids = ?, name = ?, date_created = ?, place_created = ?, media = ?, canvas_type = ?, size = ?, frame = ?, description = ?, price = ?, currency = ?, image = ?, imgalt = ?, status = ? 
            WHERE sculpture_id = ?
        ");
        if ($stmt === false) {
            die('Prepare failed: ' . htmlspecialchars($this->connection->error));
        }

        $stmt->bind_param(
            'sssssssssssssss',
            $data['artists'],
            $data['name'],
            $data['creationDate'],
            $data['place'],
            $data['media'],
            $data['canvasType'],
            $data['size'],
            $data['frame'],
            $data['description'],
            $data['price'],
            $data['currency'],
            $data['image'],
            $data['name'],
            $data['availability'],
            $data['sculpId']
        );

        if ($stmt->execute()) {
            $sculptureId = $data['sculpId'];
            $fetchStmt = $this->connection->prepare("SELECT s.sculpture_id, s.name, s.image, s.price, s.currency, s.cr_at,
                JSON_ARRAYAGG(JSON_OBJECT('user_id', u.user_id, 'first_name', u.first_name, 'last_name', u.last_name)) AS users
                FROM {$this->sculpture} AS s
                LEFT JOIN {$this->users} AS u 
                ON JSON_CONTAINS(s.user_ids, JSON_QUOTE(u.user_id), '$')
                WHERE s.sculpture_id = ?
                GROUP BY s.id
            ");
            if ($fetchStmt === false) {
                die('Prepare failed: ' . htmlspecialchars($this->connection->error));
            }

            $fetchStmt->bind_param('s', $sculptureId);
            $fetchStmt->execute();
            $result = $fetchStmt->get_result();
            $updatedRow = $result->fetch_assoc();

            return ['data' => $updatedRow];
        } else {
            return ['error' => $stmt->error];
        }
    }
    public function delete($id)
    {
        $fetchStmt = $this->connection->prepare("SELECT image FROM {$this->sculpture} WHERE sculpture_id = ?");
        if ($fetchStmt === false) {
            die('Prepare failed: ' . htmlspecialchars($this->connection->error));
        }
        $fetchStmt->bind_param('s', $id);
        $fetchStmt->execute();
        $result = $fetchStmt->get_result();
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $imagePath = $row['image'];
            $realPath = realpath($imagePath);
            if ($realPath && file_exists($realPath)) {
                unlink($realPath);
            }
        } else {
            return ['success' => false, 'message' => 'Record not found!'];
        }
        $deleteStmt = $this->connection->prepare("DELETE FROM {$this->sculpture} WHERE sculpture_id = ?");
        if ($deleteStmt === false) {
            die('Prepare failed: ' . htmlspecialchars($this->connection->error));
        }
        $deleteStmt->bind_param('s', $id);
        if ($deleteStmt->execute()) {
            if ($deleteStmt->affected_rows > 0) {
                return ['success' => true, 'message' => 'Record and image deleted successfully!'];
            } else {
                return ['success' => false, 'message' => 'Failed to delete the record!'];
            }
        } else {
            return ['success' => false, 'message' => 'Delete query failed!'];
        }
    }
}