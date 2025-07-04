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
    public function arts($page = 1, $limit = 20, $filters = [])
    {
        $offset = ($page - 1) * $limit;
        $where = [];
        $params = [];
        $paramTypes = '';

        // Filters
        if (!empty($filters['art_name'])) {
            $where[] = "a.name LIKE ?";
            $params[] = "%" . $filters['art_name'] . "%";
            $paramTypes .= 's';
        }

        if (!empty($filters['artist_name'])) {
            $where[] = "EXISTS (SELECT 1 FROM {$this->users} u 
                WHERE JSON_CONTAINS(a.user_ids, JSON_QUOTE(u.user_id), '$') 
                AND CONCAT(u.first_name, ' ', u.last_name) LIKE ?
            )";
            $params[] = "%" . $filters['artist_name'] . "%";
            $paramTypes .= 's';
        }

        if (!empty($filters['price'])) {
            $where[] = "a.price = ?";
            $params[] = $filters['price'];
            $paramTypes .= 's';
        }

        $whereSQL = count($where) ? 'WHERE ' . implode(' AND ', $where) : '';

        // Get total count
        $countQuery = "SELECT COUNT(*) AS total FROM {$this->arts} a $whereSQL";
        $countStmt = $this->connection->prepare($countQuery);

        if ($paramTypes !== '') {
            $countStmt->bind_param($paramTypes, ...$params);
        }

        $countStmt->execute();
        $countResult = $countStmt->get_result();
        $totalRow = $countResult->fetch_assoc();
        $totalItems = (int) $totalRow['total'];
        $totalPages = ceil($totalItems / $limit);

        // Now get paginated data
        $query = "SELECT  a.*, 
                JSON_ARRAYAGG(
                    JSON_OBJECT('user_id', u.user_id, 'first_name', u.first_name, 'last_name', u.last_name)
                ) AS users
            FROM {$this->arts} AS a
            LEFT JOIN {$this->users} AS u 
                ON JSON_CONTAINS(a.user_ids, JSON_QUOTE(u.user_id), '$')
            $whereSQL
            GROUP BY a.id
            ORDER BY a.id DESC 
            LIMIT ? OFFSET ?";

        $stmt = $this->connection->prepare($query);

        // Bind parameters with limit & offset
        $paramTypesWithLimit = $paramTypes . 'ii';
        $paramsWithLimit = [...$params, $limit, $offset];

        $stmt->bind_param($paramTypesWithLimit, ...$paramsWithLimit);
        $stmt->execute();
        $result = $stmt->get_result();

        $data = [];
        while ($row = $result->fetch_assoc()) {
            $row['users'] = json_decode($row['users'], true);
            $data[] = $row;
        }

        return [
            'success' => true,
            'arts' => $data,
            'total' => $totalItems,
            'pages' => $totalPages,
            'current_page' => $page
        ];
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
    public function getArtOfArtist($artistId, $limit = 9)
    {
        $stmt = $this->connection->prepare("SELECT 
            a.*
            FROM {$this->arts} AS a
            WHERE JSON_CONTAINS(a.user_ids, JSON_QUOTE(?), '$')
            LIMIT ?
        ");
        if ($stmt === false) {
            die('Prepare failed: ' . htmlspecialchars($this->connection->error));
        }
        $stmt->bind_param('si', $artistId, $limit);
        if (!$stmt->execute()) {
            die('Execute failed: ' . htmlspecialchars($stmt->error));
        }
        $result = $stmt->get_result();
        $data = $result->fetch_all(MYSQLI_ASSOC);

        return $data;

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
    public function updateArt($data)
    {
        $stmt = $this->connection->prepare("
            UPDATE {$this->arts} 
            SET user_ids = ?, name = ?, date_created = ?, place_created = ?, media = ?, canvas_type = ?, size = ?, frame = ?, description = ?, price = ?, currency = ?, image = ?, imgalt = ?, status = ? 
            WHERE art_id = ?
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
            $data['artId']
        );

        if ($stmt->execute()) {
            $artId = $data['artId'];
            $fetchStmt = $this->connection->prepare("
                SELECT a.art_id, a.name, a.image, a.price, a.currency, a.cr_at,
                JSON_ARRAYAGG(JSON_OBJECT('user_id', u.user_id, 'first_name', u.first_name, 'last_name', u.last_name)) AS users
                FROM {$this->arts} AS a
                LEFT JOIN {$this->users} AS u 
                ON JSON_CONTAINS(a.user_ids, JSON_QUOTE(u.user_id), '$')
                WHERE a.art_id = ?
                GROUP BY a.art_id
            ");
            if ($fetchStmt === false) {
                die('Prepare failed: ' . htmlspecialchars($this->connection->error));
            }

            $fetchStmt->bind_param('s', $artId);
            $fetchStmt->execute();
            $result = $fetchStmt->get_result();
            $updatedRow = $result->fetch_assoc();

            return ['data' => $updatedRow];
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
    public function delete($id)
    {
        $fetchStmt = $this->connection->prepare("SELECT image FROM {$this->arts} WHERE art_id = ?");
        if ($fetchStmt === false) {
            die('Prepare failed: ' . htmlspecialchars($this->connection->error));
        }
        $fetchStmt->bind_param('s', $id);
        $fetchStmt->execute();
        $result = $fetchStmt->get_result();
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $imagePath = 'storage/arts/' . $row['image'];
            $realPath = realpath($imagePath);
            if ($realPath && file_exists($realPath)) {
                unlink($realPath);
            }
        } else {
            return ['success' => false, 'message' => 'Record not found!'];
        }
        $deleteStmt = $this->connection->prepare("DELETE FROM {$this->arts} WHERE art_id = ?");
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