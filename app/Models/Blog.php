<?php
namespace App\Models;

use App\Config\Database;
class Blog
{
    private $userstable = 'users';
    private $blogstable = 'blogs';
    protected $connection;
    public function __construct()
    {
        $this->connection = Database::getInstance()->getConnection();
    }
    public function paginateBlog($page = 1, $limit = 20)
    {
        $offset = ($page - 1) * $limit;
        $data = [];

        $stmt = $this->connection->prepare("SELECT 
            b.*, 
            JSON_OBJECT('first_name', u.first_name, 'last_name', u.last_name) AS user
        FROM {$this->blogstable} AS b
        LEFT JOIN {$this->userstable} AS u 
        ON b.user_id = u.user_id
        ORDER BY b.id DESC 
        LIMIT ? OFFSET ?");

        if ($stmt === false) {
            die('Prepare failed: ' . htmlspecialchars($this->connection->error));
        }

        $stmt->bind_param('ii', $limit, $offset);

        $stmt->execute();
        $result = $stmt->get_result();
        while ($row = $result->fetch_assoc()) {
            // Decode the user JSON object into an associative array
            $row['user'] = json_decode($row['user'], true);
            $body = html_entity_decode(strip_tags($row['body']));
            $words = array_slice(explode(' ', $body), 0, 20);
            $row['body'] = implode(' ', $words);
            $data[] = $row;
        }
        return $data;
    }
public function paginateUserBlog($page = 1, $limit = 20)
{
    $userId = $_SESSION['temp'];
    $offset = ($page - 1) * $limit;
    $data = [];

    $stmt = $this->connection->prepare("SELECT 
        b.*, 
        JSON_OBJECT('first_name', u.first_name, 'last_name', u.last_name) AS user
    FROM {$this->blogstable} AS b
    LEFT JOIN {$this->userstable} AS u ON b.user_id = u.user_id
    WHERE b.user_id = ?
    ORDER BY b.id DESC 
    LIMIT ? OFFSET ?");

    if ($stmt === false) {
        die('Prepare failed: ' . htmlspecialchars($this->connection->error));
    }

    $stmt->bind_param('sii', $userId, $limit, $offset);

    $stmt->execute();
    $result = $stmt->get_result();

    while ($row = $result->fetch_assoc()) {
        // Decode the user JSON object into an associative array
        $row['user'] = json_decode($row['user'], true);

        // Shorten blog body to 20 words
        $body = html_entity_decode(strip_tags($row['body']));
        $words = array_slice(explode(' ', $body), 0, 20);
        $row['body'] = implode(' ', $words);

        $data[] = $row;
    }

    return $data;
}

    public function blog($blog_id)
    {
        $stmt = $this->connection->prepare("SELECT * FROM {$this->blogstable} WHERE blog_id = ? LIMIT 1");

        if ($stmt === false) {
            die('Prepare failed: ' . htmlspecialchars($this->connection->error));
        }

        $stmt->bind_param('s', $blog_id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }
    public function store($data)
    {
        $stmt = $this->connection->prepare("INSERT INTO {$this->blogstable} (blog_id, user_id, title, body, image, imgalt) VALUES (?, ?, ?, ?, ?, ?)");
        if ($stmt === false) {
            die('Prepare failed: ' . htmlspecialchars($this->connection->error));
        }
        $stmt->bind_param('ssssss', $data['blog_id'], $data['user_id'], $data['title'], $data['body'], $data['image'], $data['title']);
        if ($stmt->execute()) {
            $insertId = $this->connection->insert_id;
            $fetchStmt = $this->connection->prepare("SELECT b.blog_id, b.title, b.image, b.cr_at,
                JSON_OBJECT('first_name', u.first_name, 'last_name', u.last_name) AS user
                FROM {$this->blogstable} AS b
                LEFT JOIN {$this->userstable} AS u ON b.user_id = u.user_id
                WHERE b.id = ?
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
        if (user()->role !== 'admin') {
            $user_id = $_SESSION['temp'];
            $checkStmt = $this->connection->prepare("SELECT blog_id FROM {$this->blogstable} WHERE blog_id = ? AND user_id = ?");
            if ($checkStmt === false) {
                die('Prepare failed: ' . htmlspecialchars($this->connection->error));
            }
            $checkStmt->bind_param('ss', $data['blog_id'], $user_id);
            $checkStmt->execute();
            $result = $checkStmt->get_result();

            if ($result->num_rows === 0) {
                return ['error' => 'You are not authorized to update this blog.'];
            }
            // Override user_id to prevent tampering
            $data['user_id'] = $user_id;
        }

        $stmt = $this->connection->prepare("UPDATE {$this->blogstable} SET user_id = ?, title = ?, body = ?, image = ?, imgalt = ? WHERE blog_id = ?");
        if ($stmt === false) {
            die('Prepare failed: ' . htmlspecialchars($this->connection->error));
        }
        $stmt->bind_param(
            'ssssss',
            $data['user_id'],
            $data['title'],
            $data['body'],
            $data['image'],
            $data['title'],
            $data['blog_id']
        );
        if ($stmt->execute()) {
            $blog_id = $data['blog_id'];
            $fetchStmt = $this->connection->prepare("SELECT b.blog_id, b.title, b.image, b.cr_at,
                JSON_OBJECT('first_name', u.first_name, 'last_name', u.last_name) AS user
                FROM {$this->blogstable} AS b
                LEFT JOIN {$this->userstable} AS u  ON b.user_id = u.user_id
                WHERE b.blog_id = ?
            ");
            if ($fetchStmt === false) {
                die('Prepare failed: ' . htmlspecialchars($this->connection->error));
            }
            $fetchStmt->bind_param('s', $blog_id);
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
        $fetchStmt = $this->connection->prepare("SELECT image FROM {$this->blogstable} WHERE blog_id = ?");
        if ($fetchStmt === false) {
            die('Prepare failed: ' . htmlspecialchars($this->connection->error));
        }
        $fetchStmt->bind_param('s', $id);
        $fetchStmt->execute();
        $result = $fetchStmt->get_result();
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $imagePath = 'storage/blogs/' . $row['image'];
            $realPath = realpath($imagePath);
            if ($realPath && file_exists($realPath)) {
                unlink($realPath);
            }
        } else {
            return ['success' => false, 'message' => 'Record not found!'];
        }
        $deleteStmt = $this->connection->prepare("DELETE FROM {$this->blogstable} WHERE blog_id = ?");
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